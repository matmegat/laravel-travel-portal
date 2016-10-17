<?php

namespace services;

class PopularTour
{
    public $id;
    public $url;
    public $name;
    public $image;
    public $tripDuration;
    public $description;
    public $price;

    public $serviceTravel;
    public $serviceJ6;

    const API_TRAVEL = 'travel';
    const API_J6 = 'j6';

    public function __construct(\services\Search\Tour\Travel $travel, \services\Search\Tour\J6 $j6)
    {
        $this->serviceTravel = $travel;
        $this->serviceJ6 = $j6;
    }

    public function get($count, $api = false)
    {
        $popularTours = [];

        if ($results = \TourView::getPopular($count, $api)) {
            foreach ($results as $result) {
                $popularTours[$result['id']] = $this->getPopularTourInfo($result['id'], $result['api']);
            }
        }

        return $popularTours;
    }

    private function getPopularTourInfo($id, $api)
    {
        $result = false;
        switch ($api) {
            case self::API_TRAVEL:
                $tour = $this->serviceTravel->getProductPrettify($id);
                $result = [
                    'id' => $id,
                    'name' => $tour['name'],
                    'url' => action('ToursController@info', $id),
                    'image' => !empty($tour['images'][0]) ? $tour['images'][0] : false,
                    'description' => $tour['productTeaser'],
                    'price' => $tour['prices']['min'],
                    'tripDuration' => !empty($tour['quickFaresprice']['tripDuration']) ? $tour['quickFaresprice']['tripDuration'] : 1,
                ];
                break;
            case self::API_J6;
                $tour = $this->serviceJ6->getProductPrettify($id);

                $result = [
                    'id' => $id,
                    'name' => $tour['small_title'],
                    'url' => action('ToursController@viewProduct', $id),
                    'image' => $tour['image'],
                    'description' => $tour['name'],
                    'price' => $tour['minPrice'],
                    'tripDuration' => 1,
                ];
                break;
            default:
                break;
        }

        return $result;
    }

    public function storeView($tourId, $api)
    {
        $tourView = new \TourView([
            'tour_id' => $tourId,
            'ip' => \Request::getClientIp(),
            'api' => $api,
        ]);
        $tourView->save();
    }
}
