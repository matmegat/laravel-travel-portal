<?php

class BaseAdminController extends Controller
{
    public function __construct()
    {
        View::share('active_tab', '');
    }
}
