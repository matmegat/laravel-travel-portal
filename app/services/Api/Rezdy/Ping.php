<?php

namespace services\Api\Rezdy;

class Ping extends \services\Api\Rezdy
{
    public function ping()
    {
        $response = $this->sendRequest('ping');

        return !empty($response['requestStatus']['success']);
    }
}
