<?php

use services\StripeConfig;

class ToursController extends BaseController
{
    protected $layout = 'layouts.travel';
    public $pageId = 3;
    protected $apiJ6;
    protected $apiTravel;
    protected $servicePopularTour;
    protected $stripeConfig;

    public function __construct(
        \services\Api\J6 $j6,
        \services\Api\Travel $travel,
        \services\PopularTour $popularTourService
    ) {
        $this->apiJ6 = $j6;
        $this->apiTravel = $travel;
        $this->servicePopularTour = $popularTourService;
        $this->stripeConfig = new StripeConfig();

        View::share('active_tab', $this->getActiveTab());
        View::share('body_class', 'tours_page');
    }

    private function getActiveTab()
    {
        $defaultActiveTab = 'tours';

        $tourId = null;
        $route = Route::current();

        switch ($route->getActionName()) {
            case 'ToursController@viewProduct':
            case 'ToursController@bookProduct':
                $tourId = $route->getParameter('product');
                break;
            case 'ToursController@info':
                $tourId = $route->getParameter('id');
                break;
            default:
                break;
        }

        if (empty($tourId)) {
            return $defaultActiveTab;
        }

        $pageTour = PageTour::where('tour_id', '=', $tourId)->first();
        if (empty($pageTour)) {
            return $defaultActiveTab;
        }

        switch ($pageTour->page_id) {
            case 2:
                return 'diving';
            case 1:
                return 'adventure';
            default:
                return $defaultActiveTab;
        }
    }

    public function description($string)
    {
        $string = strip_tags($string);

        return $string;
    }

    public function states()
    {
        $countryId = Input::get('id', 20);

        $search = new \services\Search\Tour\Travel();

        return $search->getStates($countryId);
    }

    public function regions()
    {
        $search = new \services\Search\Tour\Travel();

        if ($stateId = \Input::get('state')) {
            return $search->getRegionsByStateId($stateId);
        } elseif ($countryId = \Input::get('id', 20)) {
            return $search->getRegionsByCountryId($countryId);
        }

        return [];
    }

    public function home()
    {
        $search = new \services\Search\Tour\Travel();

        $perPage = 10;

        $offset = (Paginator::getCurrentPage() - 1) * $perPage;

        $featureProducts = $search->search([
            'countries' => '20',
            'feature' => 1,
        ]);

        $products = $search->search([
            'records-start' => $offset,
            'records-length' => $perPage,
            'countries' => '20',
        ]);

        $paginator = Paginator::make($products, $search->getTotalDisplayRecords(), $perPage);
        $icons = AllIcons::all();
        $fun = 2;
        $selected = AllIcons::find($fun);

        return View::make('tours.index', [
            'url' => '/tours/search',
            'paginator' => $paginator,
            'featureProducts' => $featureProducts,
            'region' => 116,
            'icons' => $icons,
            'selected' => $selected,
        ]);
    }

    public function info($tourId)
    {
        $search = new \services\Search\Tour\Travel();
        $tour = $search->getProductPrettify($tourId);

        if (empty($tour)) {
            return \Redirect::action('ToursController@home');
        }

        $this->servicePopularTour->storeView($tourId, \services\PopularTour::API_TRAVEL);

        //TODO: use popular tour service ($this->servicePopularTour->get(4))
        $popularTours = [];

        return View::make('tours.info', [
            'tour' => $tour,
            'popularTours' => $popularTours,
        ]);
    }

    public function book($tourId = [])
    {
        $qty = Input::get('qty', 1);

        $priceIds = explode(',', Input::get('priceId'));

        $details = $this->getProductDetails($tourId, $priceIds, $qty);

        $this->stripeConfig->setApiKey('diving');
        Session::put('priceTour', $details['priceTour']);

        return View::make('tours.book', [
            'tour' => $details['tour'],
            'priceIds' => $priceIds,
            'qty' => $qty,
            'priceTour' => $details['priceTour'],
            'farespricesNames' => $details['farespricesNames'],
            'packageId' => $details['packageId'],
            'stripeKey' => $this->stripeConfig->getPublishableKey('diving'),
        ]);
    }

    private function getProductDetails($tourId, $priceIds, $qty)
    {
        $search = new \services\Search\Tour\Travel();
        $product = $search->getProductPrettify($tourId);

        $priceTour = 0;

        $packageId = '';
        $farespricesNames = [];
        if ($product['productClass'] == 'Z') {
            foreach ($product['faresprices'] as $faresprice) {
                foreach ($faresprice['productPricesDetails']['options'] as $option) {
                    foreach ($option['packageProducts'] as $packageProduct) {
                        if (in_array($packageProduct['productPricesDetailsId'], $priceIds)) {
                            $priceTour += $packageProduct['price'] * $qty;
                            $farespricesNames[] = $packageProduct['productName'];
                            $packageId = $faresprice['productPricesDetails']['packageId'];
                        }
                    }
                }
            }
        } else {
            if (is_array($product) && array_key_exists('faresprices', $product)) {
                foreach ($product['faresprices'] as $faresprice) {
                    if (in_array($faresprice['productPricesDetailsId'], $priceIds)) {
                        $priceTour += $faresprice['rrp'] * $qty;
                        $farespricesNames[] = $faresprice['fareName'];
                    }
                }
            }
        }

        return [
            'tour' => $product,
            'priceTour' => $priceTour,
            'farespricesNames' => $farespricesNames,
            'packageId' => $packageId,
            'qty' => $qty,
        ];
    }

    public function order()
    {
        $input = Input::except('_token');

        $priceTour = Session::get('priceTour');

        $this->stripeConfig->setApiKey('diving');
        $token = $input['stripeToken'];

        $customer = Stripe_Customer::create([
            'email' => $input['email'],
            'card' => $token,
        ]);

        $charge = Stripe_Charge::create([
            'customer' => $customer->id,
            'amount' => $priceTour * 100,
            'currency' => 'aud',
        ]);

        $error = false;
        if ($charge['paid'] == true) {
            $params = [
                'totalCharged' => $priceTour,
                'emailVouchers' => true,
                'redeemers' => [
                    [
                        'emailAddress' => $input['email'],
                        'firstName' => $input['firstname'],
                        'lastName' => $input['lastname'],
                        'phone' => $input['phone'],
                        'redeemerCountry' => $input['country'],
                    ],
                ],
            ];

            foreach ($input['priceId'] as $priceId) {
                $params['products'][] = [
                    'productPricesDetailsId' => $priceId,
                    'qty' => $input['quanity'],
                    'packageId' => !empty($input['packageId']) ? $input['packageId'] : null,
                ];

                $params['redeemers'][0]['products'][] = [
                    'productPricesDetailsId' => $priceId,
                    'redeemerQty' => $input['quanity'],
                    'bookings' => [],
                ];
            }

            $response = $this->apiTravel->setOrder($params);

            if (!empty($response['status']) && $response['status'] == 'error') {
                $error = true;
            } else {
                $pdfPath = $this->apiTravel->getVoucherPDF($response['id']);

                Mail::send('emails.tours.voucher', ['voucher' => $response['id']], function ($message) use ($pdfPath) {
                    $message->to(Input::get('email'), Input::get('firstname').' '.Input::get('lastname'))->subject('Your voucher!');
                    $message->attach($pdfPath);
                });

                Session::put('bookTourDetails', [
                    'priceIds' => $input['priceId'],
                    'qty' => $input['quanity'],
                    'productId' => $input['productId'],
                    'voucherId' => $response['id'],
                ]);

                return Redirect::action('ToursController@orderSuccess');
            }
        }

        return View::make('tours.voucher', [
            'voucher' => null,
            'error' => $error,
        ]);
    }

    public function orderSuccess()
    {
        $bookTourDetails = Session::get('bookTourDetails');

        $details = $this->getProductDetails($bookTourDetails['productId'], $bookTourDetails['priceIds'], $bookTourDetails['qty']);
        $details['voucherId'] = $bookTourDetails['voucherId'];

        $fares = [];
        foreach ($details['tour']['faresprices'] as $firesprice) {
            if (in_array($firesprice['productPricesDetailsId'], $bookTourDetails['priceIds'])) {
                $fares[] = $firesprice;
            }
        }

        return View::make('tours.bought', [
            'qty' => $details['qty'],
            'priceTour' => $details['priceTour'],
            'tour' => $details['tour'],
            'voucherId' => $details['voucherId'],
            'fares' => $fares,
        ]);
    }

    public function voucher($voucher)
    {
        if ($voucher !== null) {
            return $this->apiTravel->getVoucher($voucher);
        } else {
            return '<div class="alert alert-danger"><b>Error!</b> Something went wrong with paid.</div>';
        }
    }

    public function search()
    {
        $search = new \services\Search\Tour\Travel();

        $filters = $search->getFilters(Input::all());
        $filters['countries'] = '20';

        $products = $search->search($filters);

        if ($products === false) {
            return Redirect::action('ToursController@home');
        }

        if (!empty($filters['all'])) {
            foreach ($products as $key => $product) {
                $products[$key]['productDetails'] = preg_replace('/'.$filters['all'].'/i', '<span style="background-color: yellow;font-weight: bold;">'.$filters['all'].'</span>', $product['productDetails']);
                $products[$key]['name'] = preg_replace('/'.$filters['all'].'/i', '<span style=\'background-color: yellow;\'>'.$filters['all'].'</span>', $product['name']);
            }
        }

        $paginator = Paginator::make($products, $search->getTotalDisplayRecords(), $filters['records-length']);

        return View::make('tours.index', [
            'url' => '/tours/search',
            'paginator' => $paginator,
            'filters' => $filters,
        ]);
    }

    public function viewProduct($product)
    {
        $tour = $this->apiJ6->getProduct($product);

        $tour['quickBook'] = $tour['Next10Events'][0];
        $tour['quickBook']['Price'] = PHP_INT_MAX;
        foreach ($tour['Variations'] as $variation) {
            if ($tour['quickBook']['Price'] > $variation['Price']) {
                $tour['quickBook']['Price'] = $variation['Price'];
                $tour['quickBook']['Variation'] = $variation;
            }
        }

        $this->servicePopularTour->storeView($product, \services\PopularTour::API_J6);

        //TODO: use popular tour service ($this->servicePopularTour->get(4))
        $popularTours = [];

        return View::make('tours.product', [
            'product' => $tour,
            'popularTours' => $popularTours,
        ]);
    }

    public function bookProduct($product_id)
    {
        $qty = intval(Input::get('qty'));
        $event_id = intval(Input::get('event_id'));
        $variation_id = intval(Input::get('variation_id'));

        if (!$product_id || !$qty || !$event_id || !$variation_id) {
            return View::make('tours.product_error')->with('error', 'Not enough data to process booking request');
        }

        $product = null;

        try {
            $product = $this->apiJ6->getProduct($product_id);
        } catch (Exception $ex) {
            //do nothing
        }

        if (!$product) {
            return View::make('tours.product_error')->with('error', 'Error getting product');
        }

        // get variation price
        $price = 0;
        $variation_found = false;
        foreach ($product['Variations'] as $value) {
            if ($value['ID'] == $variation_id) {
                $variation_found = $value;
                $price = $value['Price'];
                break;
            }
        }

        if (!$price) {
            return View::make('tours.product_error')->with('error', 'Product price not found');
        }

        // check if event id exists
        $event_found = false;
        foreach ($product['Next10Events'] as $value) {
            if ($value['ID'] == $event_id) {
                $event_found = $value;
                if ($qty > $value['Quantity']) {
                    return View::make('tours.product_error')->with('error', 'Quantity is too big');
                }
                break;
            }
        }

        if (!$event_found) {
            return View::make('tours.product_error')->with('error', 'Event not found');
        }

        $this->stripeConfig->setApiKey('diving');

        return View::make('tours.product_book', [
            'product' => $product,
            'qty' => $qty,
            'event' => $event_found,
            'variation' => $variation_found,
            'price' => $price * $qty,
            'countries' => Config::get('countries.countries'),
            'stripeKey' => $this->stripeConfig->getPublishableKey($account),
        ]);
    }

    public function orderProduct($product_id)
    {
        $qty = intval(Input::get('qty'));
        $event_id = intval(Input::get('event_id'));
        $variation_id = intval(Input::get('variation_id'));

        if (!$product_id || !$qty || !$event_id || !$variation_id) {
            return View::make('tours.product_error')->with('error', 'Not enough data to process booking request');
        }

        try {
            $product = $this->apiJ6->getProduct($product_id);
        } catch (\Exception $e) {
            $product = null;
        }

        if (!$product) {
            return View::make('tours.product_error')->with('error', 'Error getting product');
        }

        // get variation price
        $price = 0;
        $variation_found = false;
        foreach ($product['Variations'] as $value) {
            if ($value['ID'] == $variation_id) {
                $variation_found = $value;
                $price = $value['Price'];
                break;
            }
        }

        if (!$price) {
            return View::make('tours.product_error')->with('error', 'Product price not found');
        }

        // check if event id exists
        $event_found = false;
        foreach ($product['Next10Events'] as $value) {
            if ($value['ID'] == $event_id) {
                $event_found = $value;
                if ($qty > $value['Quantity']) {
                    return View::make('tours.product_error')->with('error', 'Quantity is too big');
                }
                break;
            }
        }

        if (!$event_found) {
            return View::make('tours.product_error')->with('error', 'Event not found');
        }

        $email = Input::get('email');
        if (!$email) {
            return View::make('tours.product_error')->with('error', 'Email address is required');
        }

        // try to complete ordering process firstly and then charge customer
        $order = $this->apiJ6->createOrder();

        $orderID = isset($order['response']['ExternalOrderID']) ? $order['response']['ExternalOrderID'] : false;

        if (!$orderID) {
            return View::make('tours.product_error')->with('error', 'Order creation failed: '.var_export($order, true));
        }

        try {
            $customerDetails = [
                'surname' => Input::get('lastname'),
                'firstname' => Input::get('firstname'),
                'email' => $email,
                'mobilephone' => '+'.implode(' ', Input::get('mobilephone')),
                'country' => Input::get('country'),
            ];

            $customer = $this->apiJ6->createCustomer($customerDetails);

            $this->apiJ6->assignCustomerToOrder($customer['ID'], $orderID);
        } catch (Exception $ex) {
            $this->apiJ6->deleteOrder($orderID);

            return View::make('tours.product_error')->with('error', $ex->getMessage());
        }

        // TODO: Exceptions and refactorings
        $order = $this->apiJ6->orderAddItem($orderID, $variation_found['ID'], $event_found['ID'], $qty);

        if (!isset($order['response']['Status']) || $order['response']['Status'] != 'Cart') {
            $this->apiJ6->deleteOrder($orderID);

            return View::make('tours.product_error')->with('error', 'Order creation failed: '.var_export($order, true));
        }

        $order = $this->apiJ6->completeOrder($orderID);

        if (!isset($order['response'])) {
            $this->apiJ6->deleteOrder($orderID);

            return View::make('tours.product_error')->with('error', 'Order creation failed: '.var_export($order, true));
        }

        $this->stripeConfig->setApiKey('diving');
        $token = Input::get('stripeToken');

        $customer = Stripe_Customer::create([
            'email' => $email,
            'card' => $token,
        ]);

        $charge = Stripe_Charge::create([
            'customer' => $customer->id,
            'amount' => $price * 100,
            'currency' => 'aud',
        ]);

        if ($charge['paid'] == true) {
            /*
            $result = $this->_getProductOrderDetails($order['response'], $product, $event_id);

            Mail::send('emails.tours.j6order', array('order' => $order['response'], 'product' => $product) + $result, function ($message) use ($email) {
                $message->to(Input::get('email'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Your order!');
            });
            */

            return Redirect::action('ToursController@boughtProduct', ['product' => $product_id, 'order_id' => $orderID, 'variation_id' => $variation_id, 'event_id' => $event_id, 'qty' => $qty]);
        } else {
            $this->apiJ6->deleteOrder($orderID);

            return View::make('tours.product_error')->with('error', 'We were unable to process the payment');
        }
    }

    public function boughtProduct($product_id, $order_id)
    {
        $event_id = intval(Input::get('event_id'));
        $product = null;

        try {
            $productAPI = $this->apiJ6->getProduct($product_id);
            $orderAPI = $this->apiJ6->getOrder($order_id);
        } catch (Exception $ex) {
            //do nothing
        }

        if (!$productAPI) {
            return View::make('tours.product_error')->with('error', 'Error getting product');
        }

        if (!$orderAPI) {
            return View::make('tours.product_error')->with('error', 'Error getting order');
        }

        $product = $productAPI;
        $order = $orderAPI['response'];

        $result = $this->_getProductOrderDetails($order, $product, $event_id);

        if (!$order) {
            return View::make('tours.product_error')->with('error', 'Error getting order: '.var_export($order, true));
        }

        return View::make('tours.product_bought', [
            'product' => $product,
            'order' => $order,
        ] + $result);
    }

    public function _getProductOrderDetails($order, $product, $eventId)
    {
        $orderItems = null;

        $productVariations = $product['Variations'];

        foreach ($product['Next10Events'] as $value) {
            if ($value['ID'] == $eventId) {
                $event = $value;
                break;
            }
        }

        $total = 0;

        foreach ($order['Items'] as $oItem) {
            foreach ($productVariations as $variation) {
                if ($variation['ID'] == $oItem['ProductVariationID']) {
                    $orderItems[] = [
                        'variation' => $variation,
                        'item' => $oItem,
                    ];
                    $total += (intval($oItem['UnitPrice']) * intval($oItem['Quantity']));
                }
            }
        }

        return [
            'orderItems' => $orderItems,
            'event' => $event,
            'total' => $total,
        ];
    }
}
