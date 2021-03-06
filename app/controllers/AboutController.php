<?php

class AboutController extends BaseController
{
    protected $pageId = 6;

    public function __construct()
    {
        //page ID = 6
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        View::share('active_tab', 'about');
        View::share('weekday', strtoupper(date('l')));
    }
    public function index()
    {
        return View::make('about.index');
    }
}
