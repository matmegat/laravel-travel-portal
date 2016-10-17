<?php

class FaqController extends BaseController
{
    protected $pageId = 14;

    public function __construct()
    {
        View::share('active_tab', 'faq');
    }

    public function index()
    {
        return View::make('faq.index');
    }
}
