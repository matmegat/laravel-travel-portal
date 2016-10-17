<?php

namespace services\Api;

class Travel
{
    const CACHE_SECTION = 'Travel';
    const CACHE_EXPIRE = 300;

    protected $client_id;
    protected $client_secret;
    protected $url;
    protected $token;
    protected $bookingReference;

    protected $useCache = true;

    public function __construct($params = [])
    {
        if (isset($params['useCache'])) {
            $this->useCache = $params['useCache'];
        }

        $this->client_id = \Config::get('travelapi.client_id');
        $this->client_secret = \Config::get('travelapi.client_secret');
        $this->url = \Config::get('travelapi.url');
    }

    protected function request($method, $url, $args = null, $decode = true, $format = null)
    {
        $ch = curl_init();

        if (!$this->token && $url != '/apiv1/token') {
            $this->initToken();
        }

        if ($this->token) {
            $url .= '?access_token='.$this->token;
        }

        $data = $args;

        if ($method == 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            if (is_array($args) && count($args)) {
                $url .= (strpos($url, '?') ? '&' : '?').http_build_query($args);
            }
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: multipart/form-data']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $header[] = 'Accept-Encoding: gzip';

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_URL, $this->url.$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $verbose = fopen('php://temp', 'rw+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        if ($format == 'pdf') {
            return ($this->url.$url);
        }

        $result = curl_exec($ch);

        rewind($verbose);
        $this->verboseLog = stream_get_contents($verbose);

        if ($decode) {
            $payload = json_decode($result, true);
        } else {
            $payload = $result;
        }

        if (isset($payload['status']) && $payload['status'] === 'error') {
            throw new \Exception("failed to call {$this->url}{$url}, received {$payload['statusCode']} {$payload['statusText']} with message {$payload['message']}.");
        }

        return $payload;
    }

    protected function initToken()
    {
        if (empty($this->token)) {
            $result = $this->request('POST', '/apiv1/token', [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
            ]);
            $this->token = $result['access_token'];
        }

        return $this->token;
    }

    public function getProducts($filters = [])
    {
        $key = __METHOD__.'::'.md5(serialize($filters));

        $data = $this->getCache($key);
        if (empty($data)) {
            $data = $this->request('GET', '/apiv1/products', $filters);
            $this->setCache($key, $data);
        }

        return $data;
    }

    public function getProductsByIds(array $productsIds)
    {
        $key = __METHOD__.'::'.md5(serialize($productsIds));

        $data = $this->getCache($key);
        if (empty($data)) {
            $data = $this->request('GET', '/apiv1/product/'.implode(',', $productsIds));
            $this->setCache($key, $data);
        }

        if (!empty($data['results'])) {
            return $data['results'];
        }

        return [];
    }

    public function getPackage($productPricesDetailsId)
    {
        $key = __METHOD__.'::'.$productPricesDetailsId;

        $data = $this->getCache($key);
        if (empty($data)) {
            $data = $this->request('GET', '/apiv1/package/'.$productPricesDetailsId);
            $this->setCache($key, $data);
        }

        return $data;
    }

    public function getImgProducts($productId)
    {
        $key = __METHOD__.'::'.$productId;

        $data = $this->getCache($key);
        if (empty($data)) {
            $data = $this->request('GET', '/apiv1/media/images/product/'.$productId);
            $this->setCache($key, $data);
        }

        return $data;
    }

    public function getImgProductsPrettify($productId)
    {
        $data = $this->getImgProducts($productId);

        return $data['results'];
    }

    public function getToursInfo(array $toursIds)
    {
        if (empty($toursIds)) {
            return [];
        }

        $key = __METHOD__.'::'.md5(serialize($toursIds));

        $tours = $this->getCache($key);
        if (empty($tours)) {
            try {
                $tours = $this->request('GET', '/apiv1/product/'.implode(',', $toursIds));
                $this->setCache($key, $tours);
            } catch (\Exception $e) {
                // TODO: add default value
            }
        }

        $result = [];

        if (!empty($tours)) {
            $result = $tours['results'];
        }

        return $result;
    }

    public function getTourInfo($tourId)
    {
        $result = null;

        $tours = $this->getToursInfo([$tourId]);
        if (!empty($tours)) {
            $result = $tours[0];
        }

        return $result;
    }

    public function getToursInfoPrettify(array $toursIds)
    {
        $results = [];

        foreach ($this->getToursInfo($toursIds) as $item) {
            $prices = [];
            foreach ($item['faresprices'] as $faresprice) {
                $prices[] = $faresprice['rrp'];
            }

            $results[$item['productId']] = [
                'productId' => $item['productId'],
                'name' => $item['name'],
                'price' => [
                    'min' => min($prices),
                    'max' => max($prices),
                ],
                'productImagePath' => $item['productImagePath'],
            ];
        }

        return $results;
    }

    protected function getBookingReference()
    {
        $result = $this->request('POST', '/apiv1/bookingreference');

        return $result['bookingReference'];
    }

    public function setOrder($params = [])
    {
        $this->bookingReference = $this->getBookingReference();

        $data = ['bookingReference' => $this->bookingReference] + $params;

        return $this->request('POST', '/apiv1/order', json_encode($data));
    }

    public function getCats($params = [])
    {
        return $this->request('GET', '/apiv1/categories/productclasses', $params);
    }

    public function getVoucher($voucherID)
    {
        return $this->request('GET', '/apiv1/voucher/'.$voucherID.'.html', [], false);
    }

    public function getVoucherPDF($voucherID)
    {
        return $this->request('GET', '/apiv1/voucher/'.$voucherID.'.pdf', [], false, 'pdf');
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

    public function getProductClasses()
    {
        $key = __METHOD__;

        $data = $this->getCache($key);
        if (empty($data)) {
            $data = $this->request('GET', '/apiv1/categories/productclasses');
            $this->setCache($key, $data);
        }

        $result = [];

        if (!empty($data['results'])) {
            foreach ($data['results'] as $item) {
                $result[$item['id']] = $item['text'];
            }
        }

        return $result;
    }

    public function getCountries()
    {
        $result = [];

        $key = __METHOD__;

        $countries = $this->getCache($key);
        if (empty($countries)) {
            $countries = $this->request('GET', '/apiv1/categories/countries');
            $this->setCache($key, $countries);
        }

        if (!empty($countries)) {
            foreach ($countries['results'] as $item) {
                $result[$item['id']] = $item['text'];
            }
        }

        return $result;
    }

    public function getStates($countryId)
    {
        $result = [];

        $key = __METHOD__.'::'.$countryId;

        $states = \Cache::section(self::CACHE_SECTION)->get($key, []);
        if (empty($states)) {
            $states = $this->request('GET', '/apiv1/categories/states', [
                'countries' => $countryId,
            ]);
            \Cache::section(self::CACHE_SECTION)->put($key, $states, self::CACHE_EXPIRE);
        }

        if (!empty($states)) {
            foreach ($states['results'] as $item) {
                $result[$item['id']] = $item['text'];
            }
        }

        return $result;
    }

    public function getRegions($filters = [])
    {
        $result = [];

        $key = __METHOD__.'::'.md5(serialize($filters));

        $regions = \Cache::section(self::CACHE_SECTION)->get($key, []);
        if (empty($regions)) {
            $regions = $this->request('GET', '/apiv1/categories/regions', $filters);
            \Cache::section(self::CACHE_SECTION)->put($key, $regions, self::CACHE_EXPIRE);
        }

        if (!empty($regions)) {
            foreach ($regions['results'] as $item) {
                if (empty($item['text'])) {
                    continue;
                }

                $result[$item['id']] = $item['text'];
            }
        }

        return $result;
    }

    public function getLastUpdate($productIds)
    {
        return $this->request('GET', '/apiv1/product/lastupdate/'.$productIds, ['productIds' => $productIds]);
    }
}
