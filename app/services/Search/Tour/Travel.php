<?php

namespace services\Search\Tour;

class Travel extends \services\Search\Search
{
    private $api;

    private $totalDisplayRecords;

    private $useLocalStorage = true;

    public function __construct(array $params = [])
    {
        $this->api = new \services\Api\Travel();

        if (isset($params['useLocalStorage'])) {
            $this->useLocalStorage = $params['useLocalStorage'];
        }
    }

    public function getCacheSection()
    {
        return __CLASS__;
    }

    public function search(array $filters)
    {
        if ($this->useLocalStorage) {
            $products = $this->searchStorage($filters);
        } else {
            $products = $this->searchApi($filters);
        }

        //dd($products);

        foreach ($products as &$product) {
            $quickBookPriceId = [];
            if ($product['productClass'] == 'Z') {
                if (isset($product['faresprices'][0]['productPricesDetails']['options'])) {
                    foreach ($product['faresprices'][0]['productPricesDetails']['options'] as $option) {
                        $packageProduct = current($option['packageProducts']);
                        $quickBookPriceId[] = $packageProduct['productPricesDetailsId'];
                    }
                }
            } else {
                $quickBookPriceId[] = $product['faresprices'][0]['productPricesDetailsId'];
            }

            $product['quickBookPriceId'] = implode(',', $quickBookPriceId);

            $prices = array_fetch($product['faresprices'], 'rrp');
            $product['priceMin'] = min($prices);
            $product['priceMax'] = max($prices);
        }

        return $products;
    }

    private function searchApi(array $filters)
    {
        $products = $this->api->getProducts($filters);

        if (!empty($products['statusCode']) && in_array($products['statusCode'], [400, 500])) {
            return [];
        }

        if (empty($products['results'])) {
            $this->totalDisplayRecords = 0;

            return [];
        }

        foreach ($products['results'] as &$product) {
            $product['images'] = $this->api->getImgProductsPrettify($product['productId']);
        }

        $this->totalDisplayRecords = $products['totalDisplayRecords'];

        return $products['results'];
    }

    private function searchStorage(array $filters)
    {
        if (isset($filters['records-length']) && isset($filters['records-start'])) {
            $query = \TravelTour::take($filters['records-length']);
            $query->offset($filters['records-start']);
        } else {
            $query = \TravelTour::whereNotNull('created_at');   // stupid query to return TravelTour model, sorry ;)
        }

        if (!empty($filters['all'])) {
            $str = $filters['all'];
//            $query->where(function ($query) use ($str) {
//                $query->where('data.name', 'regex', new \MongoRegex('/'.$str.'/i'))
//                    ->orWhere('data.productDetails', 'regex', new \MongoRegex('/'.$str.'/i'));
//            });
            $query->where('data.name', 'regex', new \MongoRegex('/'.$str.'/i'))
                    ->orWhere('data.productDetails', 'regex', new \MongoRegex('/'.$str.'/i'));
        }

        if (!empty($filters['states'])) {
            $query->where('data.categories.states', '=', $filters['states']);
        }

        if (!empty($filters['regions'])) {
            $query->where('data.categories.regions', '=', $filters['regions']);
        }

        if (!empty($filters['countries'])) {
            $query->where('data.categories.countries', '=', $filters['countries']);
        }

        if (!empty($filters['productclass'])) {
            $query->where('data.productClass', '=', $filters['productclass']);
        }

        if (isset($filters['feature'])) {
            $query->where('feature', '=', $filters['feature']);
        }

        if (isset($filters['homepage_tours_australia'])) {
            $query->where('homepage_tours_australia', '=', $filters['homepage_tours_australia']);
        }

        if (isset($filters['homepage_tours_sale'])) {
            $query->where('homepage_tours_sale', '=', $filters['homepage_tours_sale']);
        }

        $products = $query->get();

        $query->offset(0);
        $this->totalDisplayRecords = $query->count();

        $results = [];

        if (!empty($products)) {
            foreach ($products as $product) {
                $attributes = $product->getAttributes();

                $results[] = array_merge(
                    $attributes['data'],
                    ['images' => $attributes['images']],
                    [
                        'feature' => (array_key_exists('feature', $attributes) ? $attributes['feature'] : 0),
                        'homepage_tours_australia' => (array_key_exists('homepage_tours_australia', $attributes) ? $attributes['homepage_tours_australia'] : 0),
                        'homepage_tours_sale' => (array_key_exists('homepage_tours_sale', $attributes) ? $attributes['homepage_tours_sale'] : 0),
                    ]
                );
            }
        }

        return $results;
    }

    public function storeProducts(array $products)
    {
        foreach ($products as $value) {
            $id = $value['productId'];

            $model = \TravelTour::firstOrNew(['_id' => $id]);

            $model->images = $value['images'];
            unset($value['images']);
            $model->data = $value;

            $model->save();
        }
    }

    public function storeProduct(array $product)
    {
        $this->storeProducts([$product]);
    }

    public function getProduct($id)
    {
        if (!$model = \TravelTour::find((int) $id)) {
            return;
        }

        $item = $model->getAttributes();

        return array_merge(
            $item['data'],
            ['images' => $item['images']],
            [
                'feature' => (array_key_exists('feature', $item) ? $item['feature'] : 0),
                'homepage_tours_australia' => (array_key_exists('homepage_tours_australia', $item) ? $item['homepage_tours_australia'] : 0),
                'homepage_tours_sale' => (array_key_exists('homepage_tours_sale', $item) ? $item['homepage_tours_sale'] : 0),
            ]
        );
    }

    public function saveFeatureFlags($tourId, $flag)
    {
        $product = \TravelTour::find((int) $tourId);

        if (is_null($product)) {
            return false;
        }

        if (is_null($product->getAttribute($flag)) || $product->{$flag} == 0) {
            $product->{$flag} = 1;
        } else {
            $product->{$flag} = 0;
        }

        $product->save();

        return true;
    }

    public function getProductsPrettify($ids)
    {
        $results = [];

        foreach ($ids as $id) {
            $tour = $this->getProduct($id);
            if (!$tour) {
                continue;
            }

            $result = [
                'name' => $tour['name'],
                'faresprices' => $tour['faresprices'],
                'productTeaser' => $tour['productTeaser'],
                'address' => $tour['address'],
                'productImagePath' => $tour['productImagePath'],
                'productId' => $tour['productId'],
                'itinerary' => $tour['itinerary'],
                'pickups' => $tour['pickups'],
                'productDetails' => $tour['productDetails'],
                'instructions' => $tour['instructions'],
                'quickFaresprice' => $tour['faresprices'][0],
                'productClass' => $tour['productClass'],
            ];

            $result['prices']['min'] = $result['quickFaresprice']['rrp'];
            $result['prices']['max'] = $result['quickFaresprice']['rrp'];
            $result['prices']['currency'] = $result['quickFaresprice']['fareCurrencyCode'];

            foreach ($tour['faresprices'] as $faresprices) {
                if ($faresprices['rrp'] < $result['prices']['min']) {
                    $result['prices']['min'] = $faresprices['rrp'];
                    $result['quickFaresprice'] = $faresprices;
                }
                if ($faresprices['rrp'] > $result['prices']['max']) {
                    $result['prices']['max'] = $faresprices['rrp'];
                }
            }

            if ($tour['productClass'] == 'Z') {
                $fareNames = [];
                $productPricesDetailsIds = [];
                if (array_key_exists('options', $result['quickFaresprice']['productPricesDetails'])) {
                    foreach ($result['quickFaresprice']['productPricesDetails']['options'] as $option) {
                        $packageProduct = current($option['packageProducts']);
                        $productPricesDetailsIds[] = $packageProduct['productPricesDetailsId'];
                        $fareNames[] = $packageProduct['productName'];
                    }
                }

                $result['quickFaresprice']['fareName'] = implode('&', $fareNames);
                $result['quickFaresprice']['productPricesDetailsId'] = implode(',', $productPricesDetailsIds);
            }

            foreach ($tour['images'] as $imageData) {
                $result['images'][] = $imageData['path'];
            }

            $results[$id] = $result;
        }

        return $results;
    }

    public function getProductPrettify($id)
    {
        $results = $this->getProductsPrettify([$id]);

        return isset($results[$id]) ? $results[$id] : null;
    }

    public function deleteProducts(array $productsIds)
    {
        foreach ($productsIds as $productsId) {
            \TravelTour::destroy((int) $productsId);
        }
    }

    public function getTotalDisplayRecords()
    {
        return $this->totalDisplayRecords;
    }

    public function getCountries()
    {
        $result = [
            '' => '',
        ];

        return $result;
    }

    public function getStates($countryId)
    {
        $results = [];

        $states = \TravelState::where('country_id', '=', $countryId)
            ->get();
        if (!empty($states)) {
            foreach ($states as $item) {
                $results[$item->id] = $item->name;
            }
        }

        return $results;
    }

    public function getRegionsByStateId($stateId)
    {
        $results = [];

        $regions = \TravelRegion::where('state_id', '=', $stateId)
            ->get();
        if (!empty($regions)) {
            foreach ($regions as $item) {
                $results[$item->id] = $item->name;
            }
        }

        return $results;
    }

    public function getRegionsByCountryId($countryId)
    {
        $results = [];

        $statesIds = \TravelState::where('country_id', '=', $countryId)->lists('id');
        if (empty($statesIds)) {
            return $results;
        }

        $regions = \TravelRegion::whereIn('state_id', $statesIds)
            ->get();
        if (!empty($regions)) {
            foreach ($regions as $item) {
                $results[$item->id] = $item->name;
            }
        }

        return $results;
    }
}
