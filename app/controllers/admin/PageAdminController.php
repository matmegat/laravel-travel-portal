<?php

class PageAdminController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function manage()
    {
        return View::make('admin.pages.manage', [
            'list' => \PageName::all(),
            'social' => \PageSocial::first(),
            'bookingInfo' => \PageContact::first(),
        ]);
    }

    private function getToursAccounts($pageId)
    {
        switch ($pageId) {
//            case 1:
//                return array('adventure');
//            case 2:
//                return array('diving');
            case 10:
                return ['diving', 'adventure'];
            default:
                return [];
        }
    }

    public function edit($pageId)
    {
        $page = \PageContent::where('page_id', '=', $pageId)->first();

        // If contact page:
        if ($pageId == 8) {
            return View::make('contact.edit', [
                'info' => $page,
                'page' => Contact::first(),
                'id' => $pageId,
            ]);
        }

        $toursAccounts = $this->getToursAccounts($pageId);
        $params = [
            'id' => $pageId,
            'toursEdit' => !empty($toursAccounts),
        ];

        if ($params['toursEdit']) {
            $rezdyService = new \services\Search\Tour\Rezdy();

            $tours = [];
            foreach ($toursAccounts as $account) {
                $tours[$account] = [];
                $params['selectedTours'][$account] = [];
                foreach ($rezdyService->getProductApi($account)->getProducts() as $tour) {
                    $tours[$account][$tour['productCode']] = $tour['name'];
                }
            }

            $params['tours'] = $tours;
            foreach ($page->tours()->get() as $tour) {
                $params['selectedTours'][$tour['account']][] = $tour['tour_id'];
            }
        }

        if (!empty($page)) {
            $params['page'] = $page;
            $params['pageInfo'] = \services\Page::getPageInfo($pageId);
        }

        return View::make('admin.pages.edit', $params);
    }

    public function editProcess($id)
    {
        $pageInfo = [];

        $data = Input::get('page');
        $toursAssigned = Input::get('toursAssigned');

        $pageInfo['title'] = $data['title'];
        $pageInfo['content'] = $data['short_content'];
        $pageInfo['keywords'] = $data['keywords'];
        $pageInfo['description'] = $data['description'];

        if ($pageFiles = Input::file('page')) {
            $pageInfo['backgroundFile'] = $pageFiles['background'];
        }

        services\Page::setPageInfo($id, $pageInfo);

        \PageTour::where('page_id', '=', $id)->delete();

        if (!empty($toursAssigned)) {
            foreach ($toursAssigned as $account => $tours) {
                foreach ($tours as $tourId) {
                    $pageTour = new PageTour();
                    $pageTour->page_id = $id;
                    $pageTour->tour_id = $tourId;
                    $pageTour->account = $account;
                    $pageTour->save();
                }
            }
        }

        return Redirect::back();
    }

    public function saveSocial()
    {
        $data = \Input::all();
        $data = $data['soc'];

        $social = \PageSocial::find(1);
        $social->facebook = $data['facebook'];
        $social->twitter = $data['twitter'];
        $social->googleplus = $data['googleplus'];
        $social->youtube = $data['youtube'];
        $social->save();

        return \Redirect::back();
    }

    public function saveBookingInfo()
    {
        $data = \Input::all();

        $bookingInfo = \PageContact::find(1);
        $bookingInfo->visitsname = $data['bin']['visitsname'];
        $bookingInfo->phone = $data['bin']['phone'];
        $bookingInfo->add_phone = $data['bin']['add_phone'];
        $bookingInfo->email = $data['bin']['email'];
        $bookingInfo->address = $data['bin']['address'];
        $bookingInfo->city = $data['bin']['city'];
        $bookingInfo->save();

        return \Redirect::back();
    }

    public function removeBackground($pageId)
    {
        services\Page::removeBackground($pageId);

        return Redirect::action('AdventureController@edit', [
            'id' => $pageId,
        ]);
    }

    /*
    public function updateTourProcess()
    {
        $data = Input::all();

        foreach ($data['id'] as $key => $value) {
            $tour_page_ids = PageTour::where('tour_id', '=', $key)->get();
            $tour_page_ids = PageTour::find($tour_page_ids[0]->id);
            $tour_page_ids->page_id = $value;
            $tour_page_ids->save();
        }

        return Redirect::back();
    }
    */
}
