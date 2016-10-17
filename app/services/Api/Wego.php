<?php

namespace services\Api;

class Wego
{
    protected $api_key;
    protected $ts_code;

    /**
     * Query method: POST or GET.
     *
     * @var string
     */
    protected $method = 'POST';

    protected $protocol = 'http://';
    protected $api_url;

    protected $verbose_log = '';

    protected $currency = 'USD';

    public function __construct($api_key, $ts_code, $api_url = null)
    {
        $this->api_key = $api_key;
        $this->ts_code = $ts_code;
        $this->api_url = $api_url;
    }

    public function set_currency($value)
    {
        $this->currency = $value;
    }

    public function set_url($url)
    {
        $this->api_url = $url;
    }

    public function set_method($method)
    {
        $this->method = strtoupper($method);
    }

    public function set_protocol($protocol)
    {
        $this->protocol = strtolower($protocol);
    }

    public function build_query($name, $data, $api_url = null, $question = false)
    {
        $data = [
            'api_key' => $this->api_key,
            'ts_code' => $this->ts_code,
        ] + $data;

        if (!$api_url) {
            $api_url = $this->api_url;
        }

        if (!$question) {
            $url = $this->protocol.$api_url.$name.'?'.http_build_query($data);
        } else {
            $url = $this->protocol.$api_url.$name.http_build_query($data);
        }

        return $url;
    }

    public function call_url($url, $args = [])
    {
        $ch = curl_init();

        if (count($args)) {
            assert(count($args) == 1);

            if (isset($args[0]['currency_code'])) {
                $currency_code = $args[0]['currency_code'];
            } else {
                $currency_code = $this->currency;
            }

            $data = [
                    'currency_code' => $currency_code,
                ] + $args[0];

            $data = json_encode($data);

            if ($this->method == 'GET') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            } else {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }

        $header[] = 'Content-Type: application/json';
        $header[] = 'Accept: application/json';
        $header[] = 'Accept-Encoding: gzip';

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'rw+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        $result = curl_exec($ch);

        rewind($verbose);
        $this->verbose_log = stream_get_contents($verbose);

        $info = curl_getinfo($ch);

        $response = json_decode($result, true);

        if ($info['http_code'] != 200 && isset($response['message'])) {
            throw new \Exception($response['message']);
        }

        if (isset($response['error'])) {
            throw new \Exception($response['error']);
        }

        return $response;
    }

    public function __call($name, $args)
    {
        $url = $this->protocol.$this->api_url.$name
                .'?api_key='.$this->api_key
                .'&ts_code='.$this->ts_code
        ;

        return $this->call_url($url, $args);
    }

    public function get_http_dump()
    {
        return $this->verbose_log;
    }
}
