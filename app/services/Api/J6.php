<?php

namespace services\Api;

class J6
{
    const CACHE_SECTION = 'J6';
    const CACHE_EXPIRE = 300;

    protected $url;
    protected $token;

    protected $useCache = true;

    public function __construct($params = [])
    {
        if (isset($params['useCache'])) {
            $this->useCache = $params['useCache'];
        }

        $this->url = \Config::get('j6api.url');
        $this->token = \Config::get('j6api.token');
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

    protected function request($method, $url, $args = null, $decode = true, $format = null)
    {
        $ch = curl_init();

        if ($this->token) {
            $url .= '?token='.$this->token;
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
            $obj = json_decode($result, true);
        } else {
            $obj = $result;
        }

        if (!$obj) {
            echo $this->verboseLog;
            var_export($args);
            die();
        }

        return $obj;
    }

    public function getAllProducts()
    {
        $key = __METHOD__;

        $products = $this->getCache($key);
        if (empty($products)) {
            $products = $this->request('GET', '/products', ['live' => 1]);
            $this->setCache($key, $products);
        }

        return $products;
    }

    public function getProduct($productId)
    {
        $key = __METHOD__.'::'.$productId;

        $data = $this->getCache($key);
        if (empty($data)) {
            $data = $this->request('GET', '/products', ['ProductID' => $productId]);
            $this->setCache($key, $data);
        }

        if (!empty($data['response'])) {
            return $data['response'];
        }

        return;
    }

    public function createOrder()
    {
        return $this->request('GET', '/neworder', []);
    }

    public function getOrder($orderID)
    {
        return $this->request('GET', '/order', ['orderid' => $orderID]);
    }

    public function createCustomer($customerDetails)
    {
        $requiredFields = [
            'mobilephone',
            'country',
        ];

        foreach ($requiredFields as $reqField) {
            if (!array_key_exists($reqField, $customerDetails) || empty($customerDetails[$reqField])) {
                throw new \InvalidArgumentException('Customer cannot be created. Required field is missing. '.var_export($reqField, true));
            }
        }

        $apiRequest = $this->request('GET', '/newcustomer', $customerDetails);

        if (isset($apiRequest['message'])) {
            throw new \Exception('API responded with message '.var_export($apiRequest, true));
        }

        if (!isset($apiRequest['response']['ID'])) {
            throw new \Exception('Customer couldnt be created '.var_export($apiRequest, true));
        }

        return $apiRequest['response'];
    }

    public function assignCustomerToOrder($customerID, $orderID)
    {
        if (empty($customerID)) {
            throw new \InvalidArgumentException('Customer ID is incorrct. '.var_export($customerID, true));
        }

        if (empty($orderID)) {
            throw new \InvalidArgumentException('Order ID is incorrct. '.var_export($orderID, true));
        }

        $apiRequest = $this->request(
            'GET',
            '/orderaddcustomer',
            [
                'orderid' => $orderID,
                'customerid' => $customerID,
            ]
        );

        if (isset($apiRequest['message'])) {
            throw new \Exception('API responded with message '.var_export($apiRequest, true));
        }

        if (isset($apiRequest['response']['ExternalOrderID'])) {
            return true;
        }

        return false;
    }

    public function clearOrder($orderID)
    {
        return $this->request('GET', '/clearorder', ['orderid' => $orderID]);
    }

    public function deleteOrder($orderID)
    {
        return $this->request('GET', '/deleteorder', ['orderid' => $orderID]);
    }

    public function orderAddItem($orderID, $variation_id, $event_id, $qty = 1)
    {
        return $this->request('GET', '/orderadditem', [
            'orderid' => $orderID,
            'productvariation' => $variation_id,
            'eventid' => $event_id,
            'quantity' => $qty,
        ]);
    }

    public function completeOrder($orderID)
    {
        return $this->request('GET', '/completeorder', ['orderid' => $orderID]);
    }
}
