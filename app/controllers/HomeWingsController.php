<?php

class HomeVisitsController extends BaseController
{
    protected $layout = 'layouts.travel';

    public function home()
    {
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);

        $products = $this->apiTravel->getProducts([
            'records-start' => 0,
            'records-length' => 5,
        ]);

        return View::make('home.index', ['products' => $products]);
    }
}
