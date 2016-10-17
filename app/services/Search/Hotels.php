<?php

namespace services\Search;

class Hotels
{
    private $api;

    const CACHE_SECTION = 'Hotels';
    const CACHE_EXPIRE = 120;

    protected $useCache = true;

    public function __construct(array $params = [])
    {
        $this->api = new \services\Api\Wego\Hotels();
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

    public function search(array $params)
    {
        if (!$search_id = $this->getSearchId($params)) {
            return $this->getEmptyResult();
        }

        return $this->getResult($search_id, $params);
    }

    public function getSearchId(array $params)
    {
        $key = __METHOD__.'::'.serialize($params);

        $search_id = $this->getCache($key);
        if (empty($search_id)) {
            try {
                $search_id = $this->api->search($params);
                $this->setCache($key, $search_id);
            } catch (\Exception $e) {
                $search_id = false;
            }
        }

        return $search_id;
    }

    public function getResult($search_id, $filters = [])
    {
        $key = implode('::', [
            __METHOD__,
            $search_id,
            serialize($filters),
        ]);

        $result = $this->getCache($key);
        if (empty($result)) {
            try {
                $result = $this->api->getResult($search_id, $filters);
                $result['search_id'] = $search_id;

                $this->setCache($key, $result);
            } catch (\Exception $e) {
                $result = $this->getEmptyResult();
            }
        }

        return $result;
    }

    private function getEmptyResult()
    {
        return [
            'hotels' => [],
            'filtered_count' => 0,
            'search_id' => false,
        ];
    }
}
