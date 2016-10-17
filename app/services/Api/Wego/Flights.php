<?php

namespace services\Api\Wego;

use Whoops\Example\Exception;

class Flights
{
    protected $wego;

    public function __construct()
    {
        $this->wego = new \services\Api\Wego(
            \Config::get('wego.key'),
            \Config::get('wego.ts'),
            \Config::get('wego.url')
        );
        $this->wego->set_currency('USD');
    }

    public static function toWegoDate($strDate)
    {
        return strftime('%Y-%m-%d', strtotime(str_replace('/', '.', $strDate)));
    }

    public function getAirportByCode($iata_code)
    {
        $data = \AirportCodes::where('iata_code', '=', $iata_code)->get();

        $data = array_map(function ($el) {
            return [
                'id' => $el['iata_code'],
                'text' => $el['iata_code'].', '.$el['name'].', '.$el['country_name'],
            ];
        }, $data->toArray());

        if (count($data)) {
            return $data[0];
        }

        return $data;
    }

    public function getAirports($query)
    {
        $data = \AirportCodes::where('name', 'like', $query.'%')
            ->orWhere('iata_code', 'like', $query.'%')
            ->orWhere('city_name', 'like', '%'.$query.'%')
            ->orWhere('city_code', 'like', $query.'%')
            ->orWhere('country_name', 'like', $query.'%')
            ->groupBy('iata_code')
            ->limit(10)
            ->get();

        $data = $data->toArray();

        usort($data, function ($a, $b) {
            $r = strcmp($a['city_code'], $b['city_code']);

            if ($r) {
                return $r;
            }

            if ($a['location_type'] == 'City') {
                return -1;
            }
            if ($b['location_type'] == 'City') {
                return 1;
            }

            return strcmp($a['iata_code'], $b['iata_code']);
        });

        $data = array_map(function ($el) {
            return [
                'id' => $el['iata_code'],
                'text' => $el['iata_code'].', '.$el['name'].', '.$el['country_name'],
            ];
        }, $data);

        return $data;
    }

    public function getDeeplink($search_id, $fare_id, $trip_id, $route)
    {
        $data = [
            'search_id' => $search_id,
            'fare_id' => $fare_id,
            'trip_id' => $trip_id,
            'route' => $route,
        ];

        $deepLinkUrl = $this->wego->build_query('deeplinks', $data, \Config::get('wego.providers_url'));

        try {
            $response = $this->wego->call_url($deepLinkUrl);
        } catch (Exception $e) {
            return false;
        }

        return $response;
    }

    public function fares($data)
    {
        return $this->wego->fares($data);
    }

    public function search($data)
    {
        if (empty($data['trips']) && !empty($data['trip'])) {
            $data['trips'] = [$data['trip']];
        }

        return $this->wego->searches($data);
    }

    public function getDebug()
    {
        return $this->wego->get_http_dump();
    }

    public function homeFlights()
    {
        $data = [
            'currency' => 'AUD',
            'from' => 'SYD,MEL,BNE,PER,ADL,OOL,CNS,CBR,HBA,DRW,TSV',
            'to' => 'PPP',
            'trip_type' => 'oneway',
            'dt_start' => self::toWegoDate(date('d.m.Y')),
            'dt_end' => self::toWegoDate(date('d.m.Y', strtotime('+3 month'))),
        ];

        $deepLinkUrl = $this->wego->build_query('from_city_to_city', $data, \Config::get('wego.flights_homepage_url'));

        $response = $this->wego->call_url($deepLinkUrl);

        $result = [];
        foreach ($response['list'] as $item) {
            $result[] = [
                'price' => $item['amount'],
                'airline' => $item['airlineCode'],
                'from' => $item['origin']['countryName'],
                'from_city_name' => $item['origin']['cityName'],
            ];
        }

        return $result;
    }
}
