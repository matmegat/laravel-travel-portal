<?php

class BaseController extends Controller
{
    /**
     * Setup the layout used by the controller.
     */
    protected function setupLayout()
    {
        // globally included in ever footer is this data
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        $data = DB::select('select * from page_contact');
        View::share('bookingInfo', $data[0]);

        //TODO: rewrite to services\Page use in all pages
        $pageContent = new stdClass();
        $pageContent->keywords = 'Visits Adventures';
        $pageContent->description = 'Visits Adventures is a website.';

        if (!empty($this->pageId)) {
            //TODO: rewrite to services\Page use in all pages
            $pageContent = PageContent::where('page_id', '=', $this->pageId)->first();

            $pageInfo = services\Page::getPageInfo($this->pageId);
        } else {
            $pageInfo = services\Page::getPageInfoDefault();
        }

        View::share('info', $pageContent);
        View::share('pageInfo', $pageInfo);

        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
}
