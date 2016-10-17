<?php

class TermsController extends BaseController
{
    protected $pageId = 6;

    public function __construct()
    {
        View::share('active_tab', 'terms');
    }
    public function index()
    {
        return View::make('terms.index');
    }
}
