<?php

namespace services\Search\Tour;

class J6 extends \services\Search\Search
{
    private $api;

    private $totalDisplayRecords;

    private $useLocalStorage = true;

    public function __construct(array $params = [])
    {
        $this->api = new \services\Api\J6();

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
            return $this->searchStorage($filters);
        } else {
            return $this->searchApi($filters);
        }
    }

    private function searchApi(array $filters)
    {
    }

    private function searchStorage(array $filters)
    {
    }

    public function storeProduct(array $product)
    {
        $id = $product['ID'];

        if (!$model = \J6Tour::find($id)) {
            $model = new \J6Tour();
            $model->id = $id;
        }

        $model->country = $product['Supplier']['Country'];
        $model->state = $product['Supplier']['State'];
        $model->data = json_encode($product);

        $model->save();
    }

    public function getProduct($id)
    {
        return $this->api->getProduct($id);
    }

    public function getProductPrettify($id)
    {
        $data = $this->getProduct($id);

        $result = [
            'name' => $data['Title'],
            'small_title' => '',
            'location' => $data['Location'],
            'image' => !empty($data['Photos'][0]['URL']) ? $data['Photos'][0]['URL'] : false,
            'features' => $data['Features'],
            'content' => strip_tags(html_entity_decode($data['Content'])),
        ];

        if (!empty($data['Supplier']['Name'])) {
            $result['small_title'] = is_array($data['Supplier']['Name']) ? $data['Supplier']['Name'][0] : $data['Supplier']['Name'];
        }

        $photos = [];
        if (!empty($data['Photos'])) {
            foreach ($data['Photos'] as $item) {
                $photos[] = $item['URL'];
            }
        }
        $result['images'] = $photos;

        $result['prices'] = [];
        foreach ($data['Variations'] as $item) {
            $result['prices'][] = $item['Price'];
        }
        $result['minPrice'] = min($result['prices']);
        $result['maxPrice'] = max($result['prices']);

        return $result;
    }

    public function deleteProducts(array $productsIds)
    {
        \J6Tour::destroy($productsIds);
    }

    public function getAll()
    {
        $data = $this->api->getAllProducts();

        return $data['response'];
    }
}
