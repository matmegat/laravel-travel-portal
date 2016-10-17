<?php

namespace services\Api;

/**
 * Class Whm.
 *
 * @see https://apidocs.rezdy.com/swagger/index.html
 */
abstract class Rezdy
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const METHOD_DELETE = 'DELETE';

    private $url;
    private $version;
    private $apiKey;

    private $curl;

    public function __construct($apiKey)
    {
        $this->url = \Config::get('rezdy.url');
        $this->version = \Config::get('rezdy.version');
        $this->apiKey = $apiKey;
    }

    private function initCurl()
    {
        if (!empty($this->curl)) {
            return true;
        }

        $this->curl = curl_init();

        $header[] = 'Content-Type: application/json';
        $header[] = 'Accept: application/json';

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    protected function get($action, array $data = [])
    {
        return $this->sendRequest(self::METHOD_GET, $action, $data);
    }

    protected function delete($action, array $data = [])
    {
        return $this->sendRequest(self::METHOD_DELETE, $action, $data);
    }

    protected function post($action, array $data = [])
    {
        return $this->sendRequest(self::METHOD_POST, $action, $data);
    }

    /**
     * @param $method
     * @param $action
     * @param array $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function sendRequest($method, $action, array $data = [])
    {
        $this->initCurl();

        if ($method == self::METHOD_GET) {
            $url = "{$this->url}/{$this->version}/{$action}?".http_build_query(array_merge(['apiKey' => $this->apiKey], $data));
        } else {
            $url = "{$this->url}/{$this->version}/{$action}?".http_build_query(['apiKey' => $this->apiKey]);
        }

//        \Debugbar::addMessage(strtoupper($method) . ' ' . $url, 'Rezdy API');
//        if ($method != self::METHOD_GET) {
//            \Debugbar::addMessage($data, 'Rezdy API');
//        }

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        if ($method == self::METHOD_GET) {
            curl_setopt($this->curl, CURLOPT_HTTPGET, true);
        }

        if (!empty($data)) {
            $data = json_encode($data);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
            $http_header[ ] = 'Content-Length: '.strlen($data);
        } else {
            $http_header[] = 'Content-Length: 0';
        }

        $result = [
            'response' => curl_exec($this->curl),
            'info' => curl_getinfo($this->curl),
        ];

        if (!in_array($result['info']['http_code'], [200, 201, 204, 422, 404, 406])) {
            $error = [
                'method' => $method,
                'action' => $action,
                'data' => $data,
                'response' => json_decode($result['response']),
            ];
            throw new \Exception('Error. '.print_r($error, true));
        }

        $response = json_decode($result['response'], true);
        if (isset($response['requestStatus']) && empty($response['requestStatus']['success'])) {
            return $response['requestStatus']['error'];
        }

        return $response;
    }
}
