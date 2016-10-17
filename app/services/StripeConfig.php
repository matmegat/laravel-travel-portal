<?php

namespace services;

use Stripe;

class StripeConfig
{
    public function getApiKey($account)
    {
        return \Config::get('stripe.api_key.'.$account);
    }

    public function getPublishableKey($account)
    {
        return \Config::get('stripe.publishable_key.'.$account);
    }

    public function setApiKey($account)
    {
        Stripe::setApiKey($this->getApiKey($account));
    }
}
