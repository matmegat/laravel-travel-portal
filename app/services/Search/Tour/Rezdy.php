<?php

namespace services\Search\Tour;

use Carbon\Carbon;

class Rezdy
{
    const CACHE_SECTION = 'Travel';
    const CACHE_EXPIRE = 300;

    private $apiPing = [];
    private $apiProduct = [];
    private $apiAvailability = [];
    private $apiBook = [];

    private $apiKey;

    protected $useCache = true;

    public function __construct($params = [])
    {
        if (isset($params['useCache'])) {
            $this->useCache = $params['useCache'];
        }
    }

    private function getCache($key, $default = [])
    {
        if (!$this->useCache) {
            return;
        }

        return \Cache::section(self::CACHE_SECTION)->get($key, $default);
    }

    private function setCache($key, $value, $expire = false)
    {
        if (!$this->useCache) {
            return;
        }

        if ($expire === false) {
            $expire = self::CACHE_EXPIRE;
        }

        \Cache::section(self::CACHE_SECTION)->put($key, $value, $expire);
    }

    public function useAccount($account)
    {
        switch ($account) {
            case 'adventure':
            case 'sailing':
            case 'diving':
                $apiKey = \Config::get('rezdy.apiKey.'.$account);

                if (empty($apiKey)) {
                    throw new \Exception("Redzy. Api key is missing for account '{$account}'");
                }

                $this->setApiKey($apiKey);
                break;
            default:
                throw new \Exception('Invalid account type');
        }

        return $this;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getCacheSection()
    {
        return __CLASS__;
    }

    public function getPingApi($account)
    {
        $this->useAccount($account);

        if (empty($this->apiPing[$account])) {
            $this->apiPing[$account] = new \services\Api\Rezdy\Ping($this->apiKey);
        }

        return $this->apiPing[$account];
    }

    /**
     * @param $account
     *
     * @return \services\Api\Rezdy\Product
     *
     * @throws \Exception
     */
    public function getProductApi($account)
    {
        $this->useAccount($account);

        if (empty($this->apiProduct[$account])) {
            $this->apiProduct[$account] = new \services\Api\Rezdy\Product($this->apiKey);
        }

        return $this->apiProduct[$account];
    }

    /**
     * @param $account
     *
     * @return \services\Api\Rezdy\Availability
     *
     * @throws \Exception
     */
    public function getAvailabilityApi($account)
    {
        $this->useAccount($account);

        if (empty($this->apiAvailability[$account])) {
            $this->apiAvailability[$account] = new \services\Api\Rezdy\Availability($this->apiKey);
        }

        return $this->apiAvailability[$account];
    }

    /**
     * @param $account
     *
     * @return \services\Api\Rezdy\Booking
     *
     * @throws \Exception
     */
    public function getBookApi($account)
    {
        $this->useAccount($account);

        if (empty($this->apiBook[$account])) {
            $this->apiBook[$account] = new \services\Api\Rezdy\Booking($this->apiKey);
        }

        return $this->apiBook[$account];
    }

    public function getTours($account)
    {
        $keyCache = implode('::', [
            __METHOD__,
            $account,
        ]);

        $tours = $this->getCache($keyCache);
        if (empty($tours)) {
            $tours = $this->getProductApi($account)->getProducts();
            foreach ($tours as &$tour) {
                $tour['prices'] = $this->getPrices($tour);
                $tour['account'] = $account;
            }
            $this->setCache($keyCache, $tours);
        }

        return $tours;
    }

    public function getTour($account, $id, $availabilityParams = [])
    {
        $keyCache = implode('::', [
            __METHOD__,
            $account,
            $id,
        ]);

        $tour = $this->getCache($keyCache);
        if (empty($tour)) {
            $tour = $this->getProductApi($account)->getProduct($id);
            $this->setCache($keyCache, $tour);
        }

        if (!empty($availabilityParams)) {
            $dateFrom = !empty($availabilityParams['dateFrom']) ? $availabilityParams['dateFrom'] : false;
            $dateTo = !empty($availabilityParams['dateTo'])   ? $availabilityParams['dateTo'] : false;

            $today = date('Y-m-d');

            if ($dateFrom < $today) {
                $dateFrom = $today;
            }

            $availability = $this->getTourAvailability($account, $tour['productCode'], $dateFrom, $dateTo);

            foreach ($availability as $key => $session) {
                if ($session['seatsAvailable'] <= 0) {
                    unset($availability[$key]);
                }
            }
            $tour['availability'] = $availability;
        } else {
            $tour['availability'] = [];
        }
        $tour['prices'] = $this->getPrices($tour);
        $tour['account'] = $account;

        return $tour;
    }

    private function getPrices($tour)
    {
        $prices = [
            'min' => PHP_INT_MAX,
            'max' => 0,
        ];

        foreach ($tour['priceOptions'] as $priceOption) {
            if ($priceOption['price'] < $prices['min']) {
                $prices['min'] = $priceOption['price'];
            }

            if ($priceOption['price'] > $prices['max']) {
                $prices['max'] = $priceOption['price'];
            }
        }

        return $prices;
    }

    public function getTourAvailability($account, $id, $dateFrom = false, $dateTo = false)
    {
        if (!$dateFrom) {
            //TODO: - set min available period
            //( rezdy get all tours and don't see on min availability for booking)
            //$dateFrom = Carbon::now()->addHours(360)->toDateString();
            $dateFrom = Carbon::now()->toDateString();
        }
        if (!$dateTo) {
            $dateTo = Carbon::createFromFormat('Y-m-d', $dateFrom)->addMonths(3)->toDateString();
        }
        $dateFrom .= '+10:00';
        $dateTo   .= '+10:00';

        $keyCache = implode('::', [
            __METHOD__,
            $account,
            $id,
            $dateFrom,
            $dateTo,
        ]);

        $data = $this->getCache($keyCache);
        if (empty($data)) {
            $data = $this->getAvailabilityApi($account)->availability($id, $dateFrom, $dateTo, true);
            $this->setCache($keyCache, $data, 1);
        }

        foreach ($data as &$item) {
            $item['startTimeUtc'] = $item['startTime'];
            $item['endTimeUtc'] = $item['endTime'];
            $item['startTime'] = Carbon::createFromTimestampUTC(strtotime($item['startTimeUtc']))->timezone('Australia/Brisbane')->toDateTimeString();
            $item['endTime'] = Carbon::createFromTimestampUTC(strtotime($item['endTimeUtc']))->timezone('Australia/Brisbane')->toDateTimeString();
        }

        return $data;
    }
}
