<?php

class ToursAdminController extends BaseAdminController
{
    public function getIndex()
    {
        $search = new \services\Search\Tour\Travel();

        $perPage = 10;
        $offset = (Paginator::getCurrentPage() - 1) * $perPage;

        $products = $search->search([
            'records-start' => $offset,
            'records-length' => $perPage,
            //'countries'      => '20',
        ]);

        $paginator = Paginator::make($products, $search->getTotalDisplayRecords(), $perPage);

        return View::make('admin.tours.index', [
            'url' => '/tours/search',
            'tours' => $paginator,
            'region' => 116,
        ]);
    }

    public function getSearch()
    {
        return $this->postSearch();
    }

    public function postSearch()
    {
        $search = new \services\Search\Tour\Travel();

        $perPage = 10;
        $offset = (Paginator::getCurrentPage() - 1) * $perPage;

        $products = $search->search([
            'records-start' => $offset,
            'records-length' => $perPage,
            //'countries'      => 20,
            'all' => \Input::get('search'),
        ]);

        $paginator = Paginator::make($products, $search->getTotalDisplayRecords(), $perPage);

        return View::make('admin.tours.index', [
            'search' => \Input::get('search', ''),
            'url' => '/tours/search',
            'tours' => $paginator,
            'region' => 116,
        ]);
    }

    public function getSetFeature($tourId)
    {
        $search = new \services\Search\Tour\Travel();
        $saved = $search->saveFeatureFlags($tourId, 'feature');

        return Redirect::back();
    }

    public function getSetHomepageToursAustralia($tourId)
    {
        $search = new \services\Search\Tour\Travel();
        $saved = $search->saveFeatureFlags($tourId, 'homepage_tours_australia');

        return Redirect::back();
    }

    public function getSetHomepageToursSale($tourId)
    {
        $search = new \services\Search\Tour\Travel();
        $saved = $search->saveFeatureFlags($tourId, 'homepage_tours_sale');

        return Redirect::back();
    }
}
