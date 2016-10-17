<?php

class HomeController extends BaseController
{
    protected $apiTravel;
    protected $apiHotels;
    protected $apiFlights;
    protected $j6;
    protected $rezdy;

    /**
     * @var string[]
     */
    private $defaultAirports = [
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

    protected $pageId = 10;

    public function __construct(
        \services\Api\Travel $travel,
        \services\Search\Hotels $hotels,
        \services\Search\Flights $flights,
        \services\Search\Tour\J6 $j6,
        \services\Search\Tour\Rezdy $rezdy
    ) {
        $this->j6 = $j6;
        $this->rezdy = $rezdy;
        $this->apiTravel = $travel;
        $this->apiHotels = $hotels;
        $this->apiFlights = $flights;
    }

    public function showMain()
    {
        View::share('active_tab', 'index_page');
        View::share('weekday', strtoupper(date('l')));

        $pageTours = \PageTour::where('page_id', '=', $this->pageId)->get();

        $tours = [];
        foreach ($pageTours as $pageTour) {
            $tours[] = $this->rezdy->getTour($pageTour->account, $pageTour->tour_id);
        }

        $tour_type = ['1' => 'ADVENTURE PARK','2' => 'Diving & Sailing Tour','3' => 'AUSTRALIA TOURS'];

        $search = new \services\Search\Tour\Travel();

        $toursAustralia = $search->search([
            'countries' => '20',
            'homepage_tours_australia' => 1,
        ]);
        $toursSale = $search->search([
            'countries' => '20',
            'homepage_tours_sale' => 1,
        ]);

        return View::make('home.index', [
            'search' => '/',
            'tours' => $tours,
            'toursAustralia' => $toursAustralia,
            'toursSale' => $toursSale,
            'tour_type' => $tour_type,
            'pageInfo' => \services\Page::getPageInfo($this->pageId),
        ]);
    }

    public function getSecureImage($image = 'images')
    {
        if (Input::has('url')) {
            $uploadPath = Config::get('site.https-'.$image.'-path');

            $url = Input::get('url');

            $fileName = hash('md5', $url);

            switch ($image) {
                case 'airlines' :
                    $pathInfo = pathinfo($url);
                    $fileName = $pathInfo['filename'];
                    break;
            }

            $file = $uploadPath.'/'.$fileName.'.png';

            $fileExists = file_exists($file);

            try {
                /** @var \Intervention\Image\Image $img */
                $img = Image::make($fileExists ? $file : $url);
                if (!$fileExists) {
                    $img->save($file);
                }

                return $img->response();
            } catch (\Intervention\Image\Exception\NotReadableException $e) {
                // throw default image?
            }
        }

        // throw default image?
        $img = Image::make(public_path().'/img/visits.png');

        return $img->response();
    }

    private function getFlightsDefaultResult()
    {
        $params = [
            'trip' => 0,
            'outbound' => date('d.m.Y', Config::get('wego.index_default_outbound_date')),
            'inbound' => '',
            'arrival' => Config::get('wego.default_destination'),
        ];

        $searchIds = [];
        $tripIds = [];
        $airportFares = [];
        $currentPage = 1;
        $filters = [];

        foreach ($this->defaultAirports as $airport) {
            $result = $this->apiFlights->search([
                'trips' => [
                    [
                        'departure_code' => $airport,
                        'arrival_code' => $params['arrival'],
                        'outbound_date' => strftime('%Y-%m-%d', strtotime(str_replace('/', '.', $params['outbound']))),
                    ],
                ],
                'adults_count' => '1',
            ]);

            $searchIds[$airport] = $result['search_id'];
            $tripIds[$airport] = $result['trip']['id'];
        }

        $airportFares = [];
        $totalRoutes = 0;
        foreach ($searchIds as $airport => $searchId) {
            if ($totalRoutes >= 10) {
                continue;
            }

            $tripId = $tripIds[$airport];

            $perPage = Config::get('wego.busiest_airport_count_per_result');

            // TODO: Do something with caching. It should be less complicated. Switch all the site from redis
            $airportFare = $this->apiFlights->fares([
                'search_id' => $searchId,
                'trip_id' => $tripId,
                'page' => 1,
                'per_page' => $perPage,
                'sort' => 'price',
                'departure_day_time_filter_type' => 'separate',
            ] + $filters);
            if (isset($airportFare['routes']) && is_array($airportFare['routes'])) {
                $totalRoutes += count($airportFare['routes']);
            }
            $airportFares[] = $airportFare;
        }

        $routes = [];

        foreach ($airportFares as $airportFare) {
            if (empty($airportFare['routes'])) {
                continue;
            }

            $routes = array_merge($routes, $airportFare['routes']);
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

    public function flightsTab($search_id, $trip_id)
    {
        $flights = $this->apiFlights->fares([
            'search_id' => $search_id,
            'trip_id' => $trip_id,
            'page' => 1,
            'per_page' => 10,
            'sort' => 'price',
            'departure_day_time_filter_type' => 'separate',
        ]);

        if (empty($flights['routes'])) {
            return '';
        }

        $flightsSearch = \Session::get('flightsSearch::' + $search_id);

        return View::make('home.flights', [
            'flights' => $flights['routes'],
            'flightsSearch' => $flightsSearch,
        ]);
    }
}
