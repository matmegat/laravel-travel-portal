<?php

class HotelsController extends BaseController
{
    protected $pageId = 4;

    private $api;
    private $hotelsService;

    public function __construct(\services\Api\Wego\Hotels $hotelsApi, \services\Search\Hotels $hotelsService)
    {
        $this->api = $hotelsApi;
        $this->hotelsService = $hotelsService;

        //page ID = 4
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);

        View::share('active_tab', 'hotels');
        View::share('body_class', 'hotels_page');
        View::share('weekday', strtoupper(date('l')));
    }

    public function index()
    {
        $params = [
            'user_ip' => Request::getClientIp(),
            'location_id' => 8829,
            'check_in' => date('d.m.Y', strtotime('+3 day')),
            'check_out' => date('d.m.Y', strtotime('+10 day')),
            'guests' => '1',
            'sort' => 'price',
            'order' => 'asc',
            'page' => Paginator::getCurrentPage(),
            'per_page' => 10,
        ];

        $results = $this->hotelsService->search($params);

        $paginator = Paginator::make($results['hotels'], $results['filtered_count'], $params['per_page']);

        return View::make('hotels.index', [
            'paginator' => $paginator,
            'filters' => $params,
            'search_id' => $results['search_id'],
            'user_filters' => Input::get('f', new stdClass()),
            'params' => ['search_id' => $results['search_id'], 'time' => time()] + Input::all(),
            'time_left' => time() - intval(Session::get('hotels.last_search_time')),
        ]);
    }

    public function redirectToSite($search_id, $hotel_id, $room_rate_id = null)
    {
        $link = $this->api->getDeeplink($search_id, $hotel_id, $room_rate_id);
        if (!$link) {
            return Redirect::action('HotelsController@index');
        }

        return Redirect::away($link['url']);

        /*return View::make('hotels.redirect', array(
            'deeplink' => $link,
        ));*/
    }

    private function getSearchFilters()
    {
        return [
            'sort' => 'price',
            'order' => 'asc',
            'check_in' => Input::get('check_in', ''),
            'check_out' => Input::get('check_out', ''),
            'page' => Paginator::getCurrentPage(),
            'per_page' => 12,
            'image_width' => 513,
            'image_height' => 184,
        ];
    }

    public function updateResults($search_id)
    {
        $filters = $this->getSearchFilters();

        $results = $this->hotelsService->getResult($search_id, $filters);

        if (!isset($results['filtered_count'])) {
            return 'refresh';
        }

        $params = [
            'search_id' => $search_id,
            'time' => time(),
        ] + Input::all();

        $paginator = Paginator::make($results['hotels'], $results['filtered_count'], $filters['per_page']);
        $paginator->setBaseUrl(action('HotelsController@searchResults', ['search_id' => $search_id]));

        return View::make('hotels.update-results', [
            'paginator' => $paginator,
            'filters' => $filters,
            'search_id' => $search_id,
            'params' => $params,
        ]);
    }

    public function searchResults($search_id)
    {
        $filters = $this->getSearchFilters();

        $results = $this->hotelsService->getResult($search_id, $filters);

        $paginator = false;
        if (!empty($results['filtered_count']) || !empty($results['is_done'])) {
            $paginator = Paginator::make($results['hotels'], $results['filtered_count'], $filters['per_page']);
        }

        $params = [
            'search_id' => $search_id,
            'time' => time(),
        ] + Input::all();

        return View::make('hotels.index', [
            'paginator' => $paginator,
            'filters' => $filters,
            'search_id' => $search_id,
            'params' => $params,
        ]);
    }

    public function search()
    {
        $params = Input::all();

        $params['user_ip'] = Request::getClientIp();
        $params['check_out'] = $this->api->toWegoDate($params['check_out']);
        $params['check_in'] = $this->api->toWegoDate($params['check_in']);

        if (strtotime($params['check_out']) <= strtotime($params['check_in'])
            || strtotime($params['check_in']) < time() - (60 * 60 * 24)
            || $params['check_out'] == '1970-01-01'
            || $params['check_in'] == '1970-01-01'
            || empty($params['location_id'])
        ) {
            return View::make('hotels.index');
        }

        Session::put('hotels.last_search_time', time());

        if (!$searchId = $this->hotelsService->getSearchId($params)) {
            return \Redirect::action('HotelsController@index');
        }

        return Redirect::action('HotelsController@searchResults', [
            'search_id' => $searchId,
        ] + Input::all());
    }

    public function location($code = '')
    {
        if (empty($code)) {
            $code = Input::get('q');
        }

        return $this->api->getLocation($code);
    }

    public function hotelDetail($search_id, $id)
    {
        try {
            $hotel = $this->api->hotelDetail($search_id, $id);
        } catch (\Exception $e) {
            for ($i = 1; $i <= 10; ++$i) {
                Cache::section('hotels')->forget('index_search_'.$i);
            }

            return Redirect::action('HotelsController@index');
        }

        return View::make('hotels.details', [
            'hotel' => $hotel['hotel'],
            'search_id' => $search_id,
        ]);
    }
}
