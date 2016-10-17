<?php

namespace services\Search;

class Flights
{
    private $api;

    const CACHE_SECTION = 'Flights';
    const CACHE_EXPIRE = 120;

    const SESSION_SEARCH_KEY = 'flights.last_search_time';

    protected $useCache = true;

    public function __construct(array $params = [])
    {
        $this->api = new \services\Api\Wego\Flights();
    }

    private function getCache($key, $default = [])
    {
        if (!$this->useCache) {
            return;
        }

        return \Cache::section(self::CACHE_SECTION)->get($key, $default);
    }

    private function setCache($key, $value, $expire = false)
    {
        if (!$this->useCache) {
            return;
        }

        if ($expire === false) {
            $expire = self::CACHE_EXPIRE;
        }

        \Cache::section(self::CACHE_SECTION)->put($key, $value, $expire);
    }

    public function getLastSearchTimeAgo()
    {
        if (!$lastSearchTime = \Session::get(self::SESSION_SEARCH_KEY)) {
            $lastSearchTime = 0;
        }

        return time() - intval($lastSearchTime);
    }

    public function search($data)
    {
        $key = __METHOD__.'::'.serialize($data);

        $result = $this->getCache($key);
        if (empty($result)) {
            try {
                $response = $this->api->search($data);
                $result = [
                    'search_id' => $response['id'],
                    'trip' => $response['trips'][0],
                ];

                \Session::put(self::SESSION_SEARCH_KEY, time());

                $this->setCache($key, $result);
            } catch (\Exception $e) {
                $result = [
                    'search_id' => 0,
                    'trip' => 0,
                ];
            }
        }

        return $result;
    }

    public function fares($data)
    {
        if (empty($data['id'])) {
            $data['id'] = \Session::getId();
        }
        if (empty($data['fares_query_type'])) {
            $data['fares_query_type'] = 'route';
        }

        $key = __METHOD__.'::'.serialize($data);

        $result = $this->getCache($key);
        if (empty($result)) {
            try {
                $result = $this->api->fares($data);
                $this->setCache($key, $result);
            } catch (\Exception $e) {
                $result = [
                    'routes' => [],
                    'filtered_routes_count' => 0,
                ];
            }
        }

        return $result;
    }
}
