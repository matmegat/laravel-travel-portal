<?php

class EcoTourismController extends BaseController
{
    protected $pageId = 12;

    public function __construct()
    {
        //page ID = 12
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        View::share('active_tab', 'ecotourism');
        View::share('weekday', strtoupper(date('l')));
    }
    public function index()
    {
        return View::make('ecotourism.index');
    }
}
