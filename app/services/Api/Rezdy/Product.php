<?php

namespace services\Api\Rezdy;

class Product extends \services\Api\Rezdy
{
    public function getProducts()
    {
        $response = $this->get('products');

        return $response['products'];
    }

    public function getProduct($code)
    {
        $response = $this->get('products/'.$code);

        return $response['product'];
    }
}
