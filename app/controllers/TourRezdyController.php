<?php

use services\StripeConfig;

class TourRezdyController extends BaseController
{
    protected $layout = 'layouts.travel';

    protected $service;
    protected $stripeConfig;

    public function __construct(\services\Search\Tour\Rezdy $rezdy)
    {
        $this->setActiveTab();
        $this->service = $rezdy;
        $this->stripeConfig = new StripeConfig();
    }

    public function tours($account)
    {
        switch ($account) {
            case 'adventure':
                $pageId = 1;
                break;
            case 'diving':
                $pageId = 2;
                break;
            case 'sailing':
                $pageId = 13;
                break;
            default:
                return \Redirect::action('HomeController@showMain');
        }

        $tours = $this->service->getTours($account);

        $count = count($tours);

        $templateName = $account.'.index';

        $pageInfo = \services\Page::getPageInfo($pageId);

        return View::make($templateName, [
            'tours' => \Paginator::make($tours, $count, 10),
            'pageInfo' => $pageInfo,
            'account' => $account,
        ]);
    }

    public function tour($account, $id, $error = '')
    {
        $params = [
            'dateFrom' => date('Y-m').'-01',
            'dateTo' => date('Y-m').'-31',
        ];

        $tour = $this->service->getTour($account, $id, $params);

        $tour['nextAvailability'] = false;
        foreach ($tour['availability'] as $availability) {
            if ($availability['seatsAvailable'] > 0) {
                $tour['nextAvailability'] = $availability;

                $startTime = strtotime($availability['startTime']);
                $endTime = strtotime($availability['endTime']);
                $hours = ($endTime - $startTime) / 3600;

                $tour['nextAvailability']['duration'] = $hours;

                break;
            }
        }

        $weekends = [];
        foreach ($tour['availability'] as $item) {
            $weekends[] = date('d.m.Y', strtotime($item['startTime']));
        }

        //$this->servicePopularTour->storeView($product, \services\PopularTour::API_J6);

        //TODO: use popular tour service ($this->servicePopularTour->get(4))
        $popularTours = [];

        $months = [];
        for ($i = 0; $i < 12; ++$i) {
            $time = strtotime("+{$i} month");
            $months[] = [
                'index' => (int) date('m', $time),
                'name' => date('F', $time),
                'enabled' => true,//$i < 4,
            ];
        }

        return View::make('rezdy.tour', [
            'item' => $tour,
            'account' => $account,
            'accountid' => $id,
            'popularTours' => $popularTours,
            'months' => $months,
            'weekends' => $weekends,
        ]);
    }

    public function getTourAvailabilityDates($account, $id, $date = null)
    {
        if (is_null($date)) {
            $date = date('Y-m');
        }

        $params = [
            'dateFrom' => $date.'-01',
            'dateTo' => date('Y-m-d', strtotime($date.'-01 next month')),
        ];

        $tour = $this->service->getTour($account, $id, $params);

        $weekends = [];
        foreach ($tour['availability'] as $item) {
            $weekends[] = date('d.m.Y', strtotime($item['startTime']));
        }

        return Response::json($weekends);
    }

    public function tourAvailability($account, $id)
    {
        if (!$travelMonth = \Input::get('travelMonth')) {
            $dateFrom = false;
            $dateTo = false;
        } else {
            $date = \Carbon\Carbon::createFromDate(null, $travelMonth, 1);

            $dateFrom = $date->toDateString();
            $dateTo = $date->addMonth()->subDay()->toDateString();
        }

        $item = $this->service->getTour(
            $account,
            $id,
            [
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ],
            false
        );

        return View::make('rezdy.tour.sessions', [
            'sessions' => $item['availability'],
            'productCode' => $item['productCode'],
            'account' => $account,
            'travelDate' => $travelMonth,
        ]);
    }

    private function countQuantityPrice($qty, $price, $minQuantity, $maxQuantity)
    {
        $qty = intval($qty);

        if ($qty < 1) {
            $qty = 1;
        }

        $min = $qty % $minQuantity;
        if ($min != 0) {
            $qty += $min;
        }

        $max = $qty % $maxQuantity;
        if ($max != 0) {
            $qty += $max;
        }

        $seats = $qty / $maxQuantity;
        $priceOutput = $seats * $price;

        $returnArray = [
            'qty' => $qty,
            'seats' => $seats,
            'price' => $priceOutput,
        ];

        return $returnArray;
    }

    public function book($account, $productCode)
    {
        $optionId = \Input::get('optionId');
        $startTime = \Input::get('startTime');

        $tour = $this->service->getTour($account, $productCode, [
            'dateFrom' => date('Y-m-d', strtotime($startTime)),
            'dateTo' => date('Y-m-d', strtotime($startTime) + 86400),
        ]);

        if (!$tour || empty($tour['availability'])) {
            return \Redirect::action('TourRezdyController@tours', ['account' => $account]);
        }

        $session = false;
        foreach ($tour['availability'] as $availabilityKey => $item) {
            if (isset($item['priceOptions'][$optionId])) {
                $session = $item;
                $selectedItem = $item['priceOptions'][$optionId];
                break;
            }
        }

        if ($session == false) {
            return \Redirect::action('TourRezdyController@tour', [
                'account' => $account,
                'id' => $productCode,
            ]);
        }

        $quantity = \Input::get('qty', 1);

//        if ($quantity > 4) {
//            return \Redirect::back()
//                ->withInput()
//                ->with('error', 'Apologize - you cant order more then 2 berths at single order');
//        }

        if (!isset($selectedItem['minQuantity'])) {
            $selectedItem['minQuantity'] = $selectedItem['seatsUsed'];
        }
        if (!isset($selectedItem['maxQuantity'])) {
            $selectedItem['maxQuantity'] = $selectedItem['seatsUsed'];
        }

        $quantityPrice = $this->countQuantityPrice($quantity, $selectedItem['price'], $selectedItem['minQuantity'], $selectedItem['maxQuantity']);

        //Try to pre book tour
        $preBook = '';
//        if (isset($tour['availability'][0]['startTimeUtc'])) {
//            $preBook = $this->getPreBookingError(
//                $account,
//                $productCode,
//                $tour['availability'][0]['startTimeUtc'],
//                $session['priceOptions'][$optionId]['id'],
//                $quantity
//            );
//
//            if (!is_null($preBook) && is_string($preBook)) {
//                return \Redirect::action("TourRezdyController@tour", array(
//                    'account' => $account,
//                    'id'      => $productCode
//                ))->withErrors(new \Illuminate\Support\MessageBag(array($preBook)));
//            }
//        }

        $bookingFields = $this->proceedBookingFields($tour);

        return View::make('rezdy.book', [
            'tour' => $tour,
            'quantityPrice' => $quantityPrice,
            'session' => $session,
            'optionId' => $optionId,
            'quantity' => $quantity,
            'account' => $account,
            'bookingFields' => $bookingFields,
            'preBook' => $preBook,
            'stripeKey' => $this->stripeConfig->getPublishableKey($account),
        ]);
    }

    private function proceedBookingFields($tour)
    {
        $bookingFields = ['perBooking' => [], 'perParticipant' => []];

        foreach ($tour['bookingFields'] as $field) {
            if ($field['requiredPerBooking']) {
                $bookingFields['perBooking'][] = $field;
            }

            if ($field['requiredPerParticipant']) {
                $bookingFields['perParticipant'][] = $field;
            }
        }

        return $bookingFields;
    }

    /**
     * Try book tour, using for booking tour before payment.  Rezdy API
     * return tours as available without accounting minimum booked time.
     * So only one way - pre booking and analyze answer status.
     *
     * @param $account
     * @param $productCode
     * @param $dateFrom
     * @param $optionId
     * @param $quantity
     *
     * @return string|null
     */
    private function getPreBookingError($account, $productCode, $dateFrom, $optionId, $quantity)
    {
        $params = [
            'customer' => [
            ],
            'items' => [
                [
                    'productCode' => $productCode,
                    'startTime' => $dateFrom,
                    'quantities' => [
                        [
                            'optionId' => $optionId,
                            'value' => $quantity,
                        ],
                    ],
                ],
            ],
            'status' => 'NEW',
            'source' => 'ONLINE',
        ];

        $response = $this->service->getBookApi($account)->addBooking($params);

        if (!empty($response['error'])) {
            return $response['error'];
        }

        if (!empty($response['orderNumber'])) {
            //$this->service->getBookApi($account)->deleteBooking($response['orderNumber']);
            return ['preBooking' => $response];
        }

        return 'Prebooking error';
    }

    public function bookProcess()
    {
        $post = \Input::all();

        if (!$account = \Input::get('account')) {
            throw new \Exception('account is missing');
        }
        $this->setActiveTab($account);

        if (!$productCode = \Input::get('productCode')) {
            throw new \Exception('productCode is missing');
        }

        $tour = $this->service->getTour($account, $productCode, true, false);

        if (!$tour) {
            throw new \Exception('tour not found');
        }

        if (!$startTime = \Input::get('startTime')) {
            throw new \Exception('startTime is missing');
        }
        if (!\Input::has('optionId')) {
            throw new \Exception('optionId is missing');
        }
        if (!$quantity = \Input::get('quantity')) {
            throw new \Exception('quantity is missing');
        }

        if (!$email = \Input::get('contact.email')) {
            throw new \Exception('email is missing');
        }
        if (!$firstName = \Input::get('contact.firstName')) {
            throw new \Exception('firstname is missing');
        }
        if (!$lastName = \Input::get('contact.lastName')) {
            throw new \Exception('lastname is missing');
        }
        if (!$mobile = \Input::get('contact.mobile')) {
            throw new \Exception('pnone is missing');
        }

        if (!$stripeToken = \Input::get('stripeToken')) {
            throw new \Exception('stripeToken is missing');
        }

        $optionId = \Input::get('optionId');

        $selectedItem = $tour['priceOptions'][$optionId];

        if (!isset($selectedItem['minQuantity'])) {
            $selectedItem['minQuantity'] = $selectedItem['seatsUsed'];
        }
        if (!isset($selectedItem['maxQuantity'])) {
            $selectedItem['maxQuantity'] = $selectedItem['seatsUsed'];
        }

        $quantityPrice = $this->countQuantityPrice($quantity, $selectedItem['price'], $selectedItem['minQuantity'], $selectedItem['maxQuantity']);

        $totalPrice = $quantityPrice['seats'] * $selectedItem['price'];

        $this->stripeConfig->setApiKey($account);

        $customer = Stripe_Customer::create([
            'email' => $email,
            'card' => $stripeToken,
        ]);

        $charge = Stripe_Charge::create([
            'customer' => $customer->id,
            'amount' => $totalPrice * 100,
            'currency' => 'aud',
        ]);

        if (!$charge->paid) {
            return \Redirect::back()
                ->withInput()
                ->with('error', 'Payment failed')
                ->with('account', $account);
        }

        $bookingFields = $this->proceedBookingFields($tour);

        $customer = [];
        foreach ($bookingFields['perBooking'] as $field) {
            $fieldName = camelCase($field['label']);
            $fieldKeyName = $fieldName;

            switch ($fieldName) {
                case 'country' :
                    $fieldKeyName = 'countryCode';
                    break;
            }

            $customer[$fieldKeyName] = \Input::get('contact.'.$fieldName, '');
        }

        $participants = [];
        foreach ($post['berth'] as $berthId => $berth) {
            $participant = $bookingFields['perParticipant'];
            foreach ($participant as &$field) {
                $fieldName = camelCase($field['label']);
                $field['value'] = \Input::get('berth.'.$berthId.'.'.$fieldName, '');

                if (array_key_exists('listOptions', $field) && !empty($field['listOptions'])) {
                    $listOptions = explode("\n", $field['listOptions']);
                    $field['value'] = $listOptions[$field['value']];
                }
            }
            $participants[] = ['fields' => $participant];
        }

        $params = [
            'customer' => $customer,
            'items' => [
                [
                    'productCode' => $productCode,
                    'startTime' => $startTime,
                    'quantities' => [
                        [
                            'optionId' => $selectedItem['id'],
                            'value' => $quantityPrice['seats'],    // to get max quantity per package
                            //"optionLabel" => "Quantity",
                            //"optionPrice" => 155,
                        ],
                    ],
                    'participants' => $participants,
                    //"totalQuantity" => $quantityPrice['qty'],
                    //"amount" => $totalPrice,
                    'subtotal' => $totalPrice,
                ],
            ],
            'status' => 'CONFIRMED',
            //"totalAmount" => 155 * $quantity,
            //"totalCurrency" => "AUD",
            //"totalPaid" => 155 * $quantity,
            //"paymentOption" => "CASH",
            'payments' => [
                [
                    'type' => 'CASH',
                    'amount' => $totalPrice,
                    'currency' => 'AUD',
                    'date' => date('c', $charge->created),
                    //"date" => date('c', time()),
                    'label' => 'Taken by Stripe',
                ],
            ],
            'source' => 'ONLINE',
        ];

        $response = $this->service->getBookApi($account)->addBooking($params);

        //dd($response, $params, $tour);

        if (!empty($response['error'])) {
            $retrieve = Stripe_Charge::retrieve($charge->id);
            $re = $retrieve->refunds->create();

            return \Redirect::back()
                ->withInput()
                ->with('error', $response['error'])
                ->with('account', $account);
        }

        return \Redirect::action('TourRezdyController@success')
            ->with('response', $response)
            ->with('account', $account);
    }

    public function success()
    {
        if (!$account = \Session::get('account')) {
            return \Redirect::action('HomeController@showMain');
        }

        if (!$response = \Session::get('response')) {
            return \Redirect::action('TourRezdyController@tours', ['account' => $account]);
        }

        $tourBookInfo = $response['items'][0];

        $tour = $this->service->getTour($account, $tourBookInfo['productCode']);
        if (!$tour) {
            return \Redirect::action("TourRezdyController@{$account}");
        }

        return View::make('rezdy.success', [
            'response' => $response,
            'tour' => $tour,
            'tourBookInfo' => $tourBookInfo,
        ]);
    }

    private function setActiveTab()
    {
        $account = \Route::current()->getParameter('account');
        if (!$account) {
            $account = \Session::get('account');
        }

        if ($account) {
            View::share('active_tab', $account);

            switch ($account) {
                case 'adventure':
                    View::share('body_class', 'adventure_page');
                    break;
                case 'diving':
                    View::share('body_class', 'diving_page');
                    break;
                default:
                    View::share('body_class', 'tours_page');
            }
        } else {
            View::share('active_tab', 'tours');
        }
    }
}
