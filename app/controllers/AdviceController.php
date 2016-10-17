<?php

class AdviceController extends BaseController
{
    protected $pageId = 7;

    public function __construct()
    {
        //page ID = 7

        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        View::share('active_tab', 'advice');
        View::share('weekday', strtoupper(date('l')));
    }
    public function index()
    {
        return View::make('advice.index');
    }
}
