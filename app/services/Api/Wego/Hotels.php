<?php

namespace services\Api\Wego;

use Whoops\Example\Exception;

class Hotels
{
    protected $wego;

    public function __construct()
    {
        $this->wego = new \services\Api\Wego(
            \Config::get('wego.key'),
            \Config::get('wego.ts'),
            \Config::get('wego.hotels_url')
        );
        $this->wego->set_currency('AUD');
    }

    public static function toWegoDate($strDate)
    {
        return strftime('%Y-%m-%d', strtotime(str_replace('/', '.', $strDate)));
    }

    public function getLocation($location)
    {
        $data = [
            'q' => $location,
        ];

        $link = $this->wego->build_query('locations/search', $data);

        $response = $this->wego->call_url($link);
        $data = array_map(function ($el) {
            return [
                'id' => $el['id'],
                'text' => $el['name'],
            ];
        }, $response['locations']);

        if (count($data) == 1) {
            return $data[0];
        }

        return $data;
    }

    public function search($data)
    {
        try {
            $link = $this->wego->build_query('search/new', $data);
            $response = $this->wego->call_url($link);
        } catch (\Exception $e) {
            return false;
        }

        if (empty($response['search_id'])) {
            return false;
        }

        return $response['search_id'];
    }

    public function historicalSearch($data)
    {
        try {
            $link = $this->wego->build_query('search/historical', $data);
            $response = $this->wego->call_url($link);

            foreach ($response['hotels'] as &$hotel) {
                $hotel['details'] = $this->hotelDetail(0, $hotel['id']);
            }
        } catch (\Exception $e) {
            $response = [
                'hotels' => [],
            ];
        }

        return $response;
    }

    public function getResult($search_id, array $params = [])
    {
        $data = [
            'search_id' => $search_id,
            'currency_code ' => !empty($params['currency_code']) ? $params['currency_code'] : 'AUD',
            'page' => !empty($params['page']) ? $params['page'] : 1,
            'per_page' => !empty($params['per_page']) ? $params['per_page'] : 12,
        ];

        if (isset($params['refresh'])) {
            $data['refresh'] = $params['refresh'];
        }
        if (isset($params['sort'])) {
            $data['sort'] = $params['sort'];
        }
        if (isset($params['order'])) {
            $data['order'] = $params['order'];
        }
        if (isset($params['popular_with'])) {
            $data['popular_with'] = $params['popular_with'];
        }
        if (isset($params['lang'])) {
            $data['lang'] = $params['lang'];
        }
        if (isset($params['callback'])) {
            $data['callback'] = $params['callback'];
        }

        $link = $this->wego->build_query('search/'.$search_id, $data);

        for ($i = 1; $i <= 5; ++$i) {
            $response = $this->wego->call_url($link);

            if (!empty($response['hotels'])) {
                break;
            }
            sleep(1);
        }

        foreach ($response['hotels'] as &$hotel) {
            $hotel['details'] = $this->hotelDetail($search_id, $hotel['id'], $params);
        }

        return $response;
    }

    public function getDeeplink($search_id, $hotel_id, $room_rate_id)
    {
        $data = [
            'hotel_id' => $hotel_id,
            'room_rate_id' => $room_rate_id,
        ];

        $deepLinkUrl = $this->wego->build_query('search/redirect/'.$search_id, $data);

        try {
            $response = $this->wego->call_url($deepLinkUrl);
        } catch (Exception $e) {
            return false;
        }

        return $response;
    }

    public function hotelDetail($search_id, $id, array $params = [])
    {
        $data = [
            'hotel_id' => $id,
        ];

        if ($search_id != 0) {
            $deepLinkUrl = $this->wego->build_query('search/show/'.$search_id, $data);
        } else {
            $deepLinkUrl = $this->wego->build_query('search/show/historical', $data);
        }

        $result = $this->wego->call_url($deepLinkUrl);

        $toWidth = !empty($params['image_width']) ? $params['image_width'] : false;
        $toHeight = !empty($params['image_height']) ? $params['image_height'] : false;

        if (!empty($result['hotel']['images'])) {
            foreach ($result['hotel']['images'] as &$image) {
                $image['url'] = $this->convertImageUrl($image['url'], $toWidth, $toHeight);
            }
        }

        if (!empty($result['hotel']['image'])) {
            $result['hotel']['image'] = $this->convertImageUrl($result['hotel']['image'], $toWidth, $toHeight);
        }

        return $result;
    }

    private function convertImageUrl($url, $width = false, $height = false)
    {
        $parts = [];
        if ($width) {
            $parts[] = 'w_'.$width;
        }
        if ($height) {
            $parts[] = 'h_'.$height;
        }
        $parts[] = 'c_fill';

        preg_match('~upload/(.+)/~U', $url, $matches);

        if (!empty($matches[1])) {
            $url = str_replace($matches[1], implode(',', $parts), $url);
        }

        return $url;
    }
}
