<?php

class SearchController extends BaseController
{
    protected $pageId = 6;

    protected $api;

    public function __construct(\services\Api\Travel $travel)
    {
        $this->api = $travel;

        $data = PageSocial::all();
        View::share('social', $data[0]);
        View::share('active_tab', '');
    }

    public function search()
    {
        $data = Input::all();
        $query = !empty($data['query']) ? $data['query'] : '';

        $search = new \services\Search\Tour\Travel();

        $products = $search->search([
            'all' => $query,
            'records-length' => 10,
            'records-start' => 1,
        ]);

        foreach ($products as &$product) {
            $product['priceMin'] = min(array_fetch($product['faresprices'], 'rrp'));
        }

        $paginator_tours = Paginator::make($products, $search->getTotalDisplayRecords(), 10);

        $news = \services\News::findNews([
            'query' => $query,
        ]);

        $pages = PageContent::whereRaw('match (`title`, `sub_title`, `content`) against (? IN BOOLEAN MODE)', [$query])->get();

        return View::make('search.results', [
            'tours' => $paginator_tours,
            'news' => $news,
            'pages' => $pages,
            'query' => $query,
        ]);
    }

    public function toursSearch()
    {
        $data = Input::all();
        $query = $data['query'];

        $hashed_query = md5($query);
        $results = Cache::section($hashed_query)->get('search');
        $paginator_tours = Paginator::make($results['tours'], count($results['tours']), 10);

        return View::make('search.results', ['tours' => $paginator_tours, 'query' => $query]);
    }

    public function blogsSearch()
    {
        $data = Input::all();
        $query = $data['query'];

        $results = News::whereRaw('MATCH(title,short_content,content) AGAINST(? IN BOOLEAN MODE)', [$query])->get();

        $paginator_blogs = [];

        if (!$results->isEmpty()) {
            $paginator_blogs = Paginator::make($results->toArray(), count($results->toArray()), 10);
        }

        return View::make('search.blogs', ['blogs' => $paginator_blogs, 'query' => $query]);
    }

    public function pagesSearch()
    {
        $data = Input::all();
        $query = $data['query'];

        $hashed_query = md5($query);
        $results = Cache::section($hashed_query)->get('search');

        $paginator_page = Paginator::make($results['page'], count($results['page']), 10);

        return View::make('search.pages', ['pages' => $paginator_page, 'query' => $query]);
    }

    // ==== AJAX STARTS HERE ====
    public function tours()
    {
        $products = $this->api->getAllProducts();

        $query = Input::get('query');

        $tours['tours'] = [];
        $count = 0;
        foreach ($products['response'] as $tour) {
            if ($count < 3) {
                preg_match('/'.$query.'/i', $tour['Title'], $matches);
                //preg_match("/".$query."/i", $tour['description'], $matches2);
                if (count($matches) > 0 /*|| count($matches2) > 0*/) {
                    $tours['tours'][] = ['title' => $tour['Title'], 'id' => $tour['ID'], 'type' => 'tour'];
                }
                ++$count;
            } else {
                break;
            }
        }
        print_r(json_encode($tours));
    }

    public function blogs()
    {
        $search = Input::get('query');

        $results = News::whereRaw('MATCH(title,short_content,content) AGAINST(? IN BOOLEAN MODE)', [$search])->get();

        $blogs['blogs'] = [];
        $count = 0;
        foreach ($results as $row) {
            if ($count < 3) {
                $blogs['blogs'][] = ['title' => $row['title'], 'id' => $row['id'], 'type' => 'blog'];
                ++$count;
            } else {
                break;
            }
        }
        print_r(json_encode($blogs));
    }

    public function pages()
    {
        $search = Input::get('query');

        $results = PageContent::whereRaw("match (`title`, `sub_title`, `content`) against ('+".$search."' IN BOOLEAN MODE)")->get();

        $page['page'] = [];
        $count = 0;
        foreach ($results as $row) {
            if ($count < 3) {
                $page['page'][] = ['title' => $row['title'], 'id' => $row['page_id'], 'type' => 'page'];
                ++$count;
            } else {
                break;
            }
        }
        print_r(json_encode($page));
    }

    public function pageRedirect($id)
    {
        switch ($id) {
            case 1:
                return Redirect::to('/tours/adventure');
                break;
            case 2:
                return Redirect::to('/tours/diving');
                break;
            case 3:
                return Redirect::to('/tours');
                break;
            case 4:
                return Redirect::to('/hotels');
                break;
            case 5:
                return Redirect::to('/flights');
                break;
            case 6:
                return Redirect::to('/about');
                break;
            case 7:
                return Redirect::to('/advice');
                break;
            case 8:
                return Redirect::to('/contact');
                break;
            default:
                return Redirect::to('/');
        }
    }
}
