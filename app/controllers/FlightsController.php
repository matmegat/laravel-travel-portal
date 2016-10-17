<?php

class FlightsController extends BaseController
{
    protected $flight_filters = [];
    protected $pageId = 5;

    private $api;
    private $service;

    public function __construct(\services\Api\Wego\Flights $api, \services\Search\Flights $service)
    {
        $this->api = $api;
        $this->service = $service;

        View::share('active_tab', 'flights');
        View::share('body_class', 'flights_page');
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        View::share('weekday', strtoupper(date('l')));
    }

    public function redirectToSite($search_id, $fare_id, $trip_id, $route)
    {
        return View::make('flights.redirect', [
            'deeplink' => $this->api->getDeeplink($search_id, $fare_id, $trip_id, $route),
            'show_departure' => Input::get('show_departure', false),
            'user_filters' => Input::get('f', [
                'stop_types' => [
                    'two_plus',
                    'one',
                    'none',
                ], ]),
            'one_way' => (bool) Input::get('one_way'),
        ]);
    }

    public function airports($iata_code = null)
    {
        $query = Input::get('q');

        if ($iata_code) {
            return $this->api->getAirportByCode($iata_code);
        }

        return $this->api->getAirports($query);
    }

    public function index()
    {
        $params = [
            'search_id' => 'popular',
            'trip_id' => 'airports',
            'show_departure' => true,
            'f' => [
                'stop_types' => [
                    'two_plus',
                    'one',
                    'none',
                ],
            ],
        ];

        //return Redirect::action('FlightsController@searchResults', $params);

        return App::make('FlightsController')->searchResults('popular', 'airports');
    }

    public function updateResults($search_id, $trip_id)
    {
        if (Input::has('load')) {
            $time_left = 35;
        } else {
            $time_left = time() - intval(Session::get('flights.last_search_time'));
        }

        $paginator = $this->_getFares($search_id, $trip_id, Input::get('f'));

        return View::make('flights.update-results', [
            'paginator' => $paginator,
            'filters' => $this->flight_filters,
            'show_departure' => Input::get('show_departure', false),
            'user_filters' => Input::get('f', new stdClass()),
            'params' => ['search_id' => $search_id, 'trip_id' => $trip_id] + Input::all(),
            'time_left' => $time_left,
        ]);
    }

    public function searchResults($search_id, $trip_id)
    {
        $paginator = null;

        // no sense to call it earlier as it will return empty response
        if ($this->service->getLastSearchTimeAgo() > 2) {
            $paginator = $this->_getFares($search_id, $trip_id, Input::get('f'));
        }

        return View::make('flights.search-results', [
            'paginator' => $paginator,
            'filters' => $this->flight_filters,
            'show_departure' => Input::get('show_departure', false),
            'user_filters' => Input::get('f', [
                'stop_types' => [
                    'two_plus',
                    'one',
                    'none',
                ], ]),
            'one_way' => (bool) Input::get('one_way'),
            'params' => ['search_id' => $search_id, 'trip_id' => $trip_id] + Input::all(),
            'time_left' => time() - intval(Session::get('flights.last_search_time')),
        ]);
    }

    public function search()
    {
        if (Input::get('departure') == '' || !Input::has('departure')) {
            Input::merge(['departure' => 'SYD']);
        }
        if (!Input::has('inbound') && !Input::has('one_way')) {
            Input::merge(['one_way' => false]);
            Input::merge(['inbound' => date('d.m.Y', strtotime('+1 month'))]);
        }
        if (Input::get('arrival') == '' || !Input::has('arrival')) {
            Input::merge(['arrival' => Config::get('wego.default_destination')]);
        }
        if (Input::get('outbound') == '' || !Input::has('outbound')) {
            Input::merge(['outbound' => date('d.m.Y')]);
        }

        $trip = [
            'departure_code' => Input::get('departure'),
            'arrival_code' => Input::get('arrival'),
            'outbound_date' => $this->api->toWegoDate(Input::get('outbound')),
        ];
        if ($inbound = Input::get('inbound')) {
            $trip['inbound_date'] = $this->api->toWegoDate($inbound);
        }

        $result = $this->service->search([
            'trips' => [$trip],
            'adults_count' => '1',
        ]);

        if (empty($result['search_id'])) {
            return \Redirect::action('FlightsController@index');
        }

        return Redirect::action('FlightsController@searchResults', [
                'search_id' => $result['search_id'],
                'trip_id' => $result['trip']['id'],
            ] + Input::all());
    }

    protected function _getFares($search_id, $trip_id, $filters)
    {
        if (!is_array($filters)) {
            $filters = [];
        }

        // TODO: handle it in a different way. Get rid of the hardcode
        if ($search_id == 'popular' && $trip_id == 'airports') {
            $paginator = $this->_getBusiestAirportsFaresPaginator($filters);
        } else {
            $paginator = $this->_getSearchFaresPaginator($search_id, $trip_id, $filters);
        }

        $paginator->setBaseUrl(
            action('FlightsController@searchResults', [
                'search_id' => $search_id,
                'trip_id' => $trip_id,
            ])
        );

        return $paginator;
    }

    private function _getSearchFaresPaginator($search_id, $trip_id, $filters = [])
    {
        $currentPage = Paginator::getCurrentPage();

        $flights = $this->service->fares([
                'search_id' => $search_id,
                'trip_id' => $trip_id,
                'page' => $currentPage,
                'per_page' => 10,
                'sort' => 'price',
                'departure_day_time_filter_type' => 'separate',
            ] + $filters);

        $flightFilters = $flights;
        unset($flightFilters['routes']);
        $this->flight_filters = $flightFilters;

        $this->formatRoutes($flights['routes']);

        return Paginator::make($flights['routes'], $flights['filtered_routes_count'], 10);
    }

    private function _getBusiestAirportsFaresPaginator($filters = [])
    {
        $airports = [
            'SYD',
            'MEL',
            'BNE',
            'PER',
            'ADL',
            'OOL',
            'CNS',
            'CBR',
            'HBA',
            'DRW',
            'TSV',
        ];

        $params = [
            'trip' => 0,
            'outbound' => date('d.m.Y', Config::get('wego.index_default_outbound_date')),
            'inbound' => '',
            'arrival' => Config::get('wego.default_destination'),
        ];

        $searchIds = [];
        $tripIds = [];
        $airportFares = [];
        $currentPage = Paginator::getCurrentPage();

        foreach ($airports as $airport) {
            $result = $this->service->search([
                'trips' => [
                    [
                        'departure_code' => $airport,
                        'arrival_code' => $params['arrival'],
                        'outbound_date' => $this->api->toWegoDate($params['outbound']),
                    ],
                ],
                'adults_count' => '1',
            ]);

            $searchIds[$airport] = $result['search_id'];
            $tripIds[$airport] = $result['trip']['id'];
        }

        foreach ($searchIds as $airport => $searchId) {
            $tripId = $tripIds[$airport];

            $perPage = Config::get('wego.busiest_airport_count_per_result');

            // TODO: Do something with caching. It should be less complicated. Switch all the site from redis
            $airportFares[] = $this->service->fares([
                    'search_id' => $searchId,
                    'trip_id' => $tripId,
                    'page' => 1,
                    'per_page' => $perPage,
                    'sort' => 'price',
                    'departure_day_time_filter_type' => 'separate',
                ] + $filters);
        }

        $routes = [];

        foreach ($airportFares as $airportFare) {
            if (empty($airportFare['routes'])) {
                continue;
            }

            $routes = array_merge($routes, $airportFare['routes']);

            // TODO: Refactor this
            $minMaxfilters = [
                'price_filter',
                'outbound_departure_day_time_filter',
                'duration_filter',
                'stopover_duration_filter',
            ];

            foreach ($minMaxfilters as $mFilter) {
                $this->flight_filters[$mFilter]['min'] = isset($this->flight_filters[$mFilter]['min']) ? min($this->flight_filters[$mFilter]['min'], $airportFare[$mFilter]['min']) : $airportFare[$mFilter]['min'];
                $this->flight_filters[$mFilter]['max'] = isset($this->flight_filters[$mFilter]['max']) ? max($this->flight_filters[$mFilter]['max'], $airportFare[$mFilter]['max']) : $airportFare[$mFilter]['max'];
            }

            $this->flight_filters['currency']['exchange_rate'] = $airportFare['currency']['exchange_rate'];

            $this->flight_filters['price_filter']['min_usd'] = isset($this->flight_filters['price_filter']['min_usd']) ? min($this->flight_filters['price_filter']['min_usd'], $airportFare['price_filter']['min_usd']) : $airportFare['price_filter']['min_usd'];
            $this->flight_filters['price_filter']['max_usd'] = isset($this->flight_filters['price_filter']['max_usd']) ? max($this->flight_filters['price_filter']['max_usd'], $airportFare['price_filter']['max_usd']) : $airportFare['price_filter']['max_usd'];

            foreach ($airportFare['airline_filters'] as $af) {
                $this->flight_filters['airline_filters'][$af['code']]['code'] = $af['code'];
                $this->flight_filters['airline_filters'][$af['code']]['name'] = $af['name'];
            }
        }

        $this->formatRoutes($routes);

        $perPage = 10;
        $pagedData = array_slice($routes, ($currentPage - 1) * $perPage, $perPage);

        return Paginator::make($pagedData, count($routes), $perPage);
    }

    private function formatRoutes(array &$routes)
    {
        $totalDuration = 0;

        foreach ($routes as &$route) {
            foreach (['outbound_segments', 'inbound_segments'] as $way) {
                if (isset($route[$way])) {
                    foreach ($route[$way] as $ind => &$outSeg) {
                        $outSeg['outtime'] = DateTime::createFromFormat('Y-m-d\TH:i:sP', $outSeg['departure_time'])->format('D d M, H:i');
                        $outSeg['intime'] = DateTime::createFromFormat('Y-m-d\TH:i:sP', $outSeg['arrival_time'])->format('D d M, H:i');
                        $duration = strtotime($outSeg['arrival_time']) - strtotime($outSeg['departure_time']);

                        $outSeg['duration'] = date('H\h\r i\m\i\n', $duration);

                        if (isset($route[$way][$ind + 1])) {
                            $next = $route[$way][$ind + 1];

                            $outSeg['layover'] = true;
                            $outSeg['layover_place'] = $outSeg['arrival_name'];
                            $ld = strtotime($next['departure_time']) - strtotime($outSeg['arrival_time']);
                            $outSeg['layover_duration'] = date('H\h\r i\m\i\n', $ld);
                            $totalDuration += $ld;
                        } else {
                            $outSeg['layover'] = false;
                        }

                        $totalDuration += $duration;
                    }
                }
            }

            $route['total_duration'] = date('H\h\r i\m\i\n', $totalDuration);
        }
    }
}
