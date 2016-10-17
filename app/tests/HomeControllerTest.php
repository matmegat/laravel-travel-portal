<?php

class HomeControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     */
    public function testHome()
    {
        $response = $this->action('GET', 'ToursController@home');
    }
}
