<?php

abstract class J6BaseController extends BaseController
{
    protected $j6;

    const PER_PAGE = 10;

    abstract public function getPageId();
    abstract public function getActiveTab();
    abstract public function getBodyClass();

    public function __construct(\services\Search\Tour\J6 $j6)
    {
        $this->j6 = $j6;

        View::share('active_tab', $this->getActiveTab());
        View::share('body_class', $this->getBodyClass());
    }

    public function index()
    {
        $query = \PageTour::where('page_id', '=', $this->getPageId());

        $count = $query->count();

        $offset = (\Paginator::getCurrentPage() - 1) * self::PER_PAGE;
        $toursIds = $query
            ->take(self::PER_PAGE)
            ->offset($offset)
            ->lists('tour_id');

        $tours = [];
        foreach ($toursIds as $tourId) {
            $product = $this->j6->getProductPrettify($tourId);

            $data = [
                'id' => $tourId,
                'name' => $product['name'],
                'small_title' => $product['small_title'],
                'location' => $product['location'],
                'additional_info' => $product['features'],
                'content' => $product['content'],
                'images' => $product['images'],
                'minPrice' => $product['minPrice'],
                'maxPrice' => $product['maxPrice'],
            ];

            $tours[] = $data;
        }

        $templateName = $this->getActiveTab().'.index';

        return View::make($templateName, [
            'tours' => \Paginator::make($tours, $count, self::PER_PAGE),
            'pageInfo' => \services\Page::getPageInfo($this->getPageId()),
        ]);
    }
}
