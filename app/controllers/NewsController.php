<?php


class NewsController extends BaseController
{
    protected $upload_dir;
    protected $upload_uri;

    public function __construct()
    {
        View::share('active_tab', 'news');
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        View::share('weekday', strtoupper(date('l')));

        $this->upload_uri = '/uploads/news/';
        $this->upload_dir = public_path().$this->upload_uri;

        View::share('upload_dir', $this->upload_dir);
        View::share('upload_uri', $this->upload_uri);
    }

    public function details($id)
    {
        $news = \services\News::getNewData($id);

        if ($news->deleted_at || $news->is_draft) {
            App::abort(404, 'News not found');
        }

        \services\News::storeNewsView($id, Request::getClientIp());

        return View::make('news.details', ['news' => $news] + $this->getSidebarFilters());
    }

    public function show($year, $slug)
    {
        $news = \services\News::getNewsBySlug($slug);

        if ($news->deleted_at || $news->is_draft) {
            App::abort(404, 'News not found');
        }

        \services\News::storeNewsView($news->id, Request::getClientIp());

        return View::make('news.details', ['news' => $news] + $this->getSidebarFilters());
    }

    protected function getNewsItem($id)
    {
        $news = News::where('domain', Config::get('site.domain'))
            ->where('id', $id)->withTrashed()->with('tags')->first();

        if (!$news) {
            App::abort(404, 'News not found');
        }

        return $news;
    }

    protected function getNewsList($tag_id = 0)
    {
        $query = News::query();

        if ($tag_id) {
            $query->has('tags', '>=', 1, 'and', function ($q) use ($tag_id) {
                return $q->where('id', '=', $tag_id);
            });
        }

        return $query->where('domain', Config::get('site.domain'))->with('tags');
    }

    protected function getSidebarFilters()
    {
        $selected_tag = Input::get('tag');

        $tagCloud = Tag::has('news', '>=', 1, 'and', function ($q) {
            return $q->where('is_draft', '=', 0)->where('domain', Config::get('site.domain'));
        })->get();

        $archives = $this->getNewsList($selected_tag)
            ->orderBy('created_at', 'desc')
            ->groupBy(DB::raw('YEAR(updated_at)'))
            ->groupBy(DB::raw('MONTH(updated_at)'))
            ->get(['created_at', DB::raw('count(*) as total')]);

        $latest_news = $this->getNewsList()->orderBy('created_at', 'desc')->limit(5)->get(['id', 'title']);

        return [
            'tag_cloud' => $tagCloud,
            'selected_tag' => $selected_tag,
            'archives' => $archives,
            'latest_news' => $latest_news,
        ];
    }

    public function listNews()
    {
        $params['count'] = 10;
        $params['offset'] = (\Paginator::getCurrentPage() - 1) * $params['count'];

        if ($date = Input::get('date')) {
            $time = strtotime(Input::get('date'));
            $t = date('t', $time);

            $params['date']['from'] = date('Y-m-01', $time);
            $params['date']['to'] = date("Y-m-{$t}", $time);
        }

        if ($tag = Input::get('tag')) {
            $params['tag'] = $tag;
        }

        $news = \Paginator::make(\services\News::findNews($params), \services\News::getTotalDisplayRecords(), $params['count']);

        // popular tours
        /*$popularToursIds = TourView::getPopularIds(3);
        $popularTours = array();*/

        if (!empty($popularToursIds)) {
            $search = new \services\Search\Tour\Travel();
            //$popularTours = $search->getProductsPrettify($popularToursIds);
        }

        $params = [
            'news' => $news,
            /*'popularTours' => $popularTours,
            'popularNews'  => \services\News::getPopularNews(3),
            'tags'         => \services\News::findTags($params),
            'archives'     => \services\News::getArchives($params),
            'date'         => Input::get('date', false),
            'tagId'        => Input::get('tag', false),*/
        ];

        return View::make('news.list', $params);
    }

    public function manageAll()
    {
        $news = $this->getNewsList()->withTrashed()->orderBy('created_at', 'desc')->paginate(15);

        return View::make('news.manage', ['news' => $news, 'news_show_all' => true]);
    }

    public function manage()
    {
        $news = $this->getNewsList()->orderBy('created_at', 'desc')->paginate(15);
        //var_dump($news); exit;
        return View::make('news.manage', ['news' => $news]);
    }

    public function restore($id)
    {
        $item = $this->getNewsItem($id);

        $item->restore();

        return Redirect::back();
    }

    public function delete($id)
    {
        $item = $this->getNewsItem($id);

        $item->delete();

        return Redirect::back();
    }

    public function add()
    {
        $available_tags = array_map(function ($item) {
            $item['id'] = $item['text'];

            return $item;
        }, Tag::where('domain', '=', Config::get('site.domain'))->get()->toArray());

        return View::make('news.add', ['available_tags' => $available_tags]);
    }

    public function addProcess()
    {
        $attributes = Input::get('news');

        $validate = $this->_validateImage(Input::get('main_image'));

        if (!$validate->passes()) {
            return Redirect::back()->withErrors($validate)->withInput();
        }

        $attributes['user_id'] = Sentry::getUser()->id;

        $attributes['domain'] = Config::get('site.domain');

        $attributes['slug'] = Str::slug($attributes['title']);
        $item = News::create($attributes);

        $this->_uploadImageForPost($item, Input::file('main_image'));

        //save tags
        $tags = Input::get('tags');

        $tags = explode(',', $tags);
        $tags = array_filter($tags);
        $tags = array_map('strtolower', $tags);
        $tags = array_map('trim', $tags);

        $tids = [];
        foreach ($tags as $tag) {
            $t = Tag::where('domain', '=', Config::get('site.domain'))->where('text', '=', $tag)->first();
            if (!$t) {
                $t = Tag::create(['text' => $tag, 'domain' => Config::get('site.domain')]);
            }
            $tids[] = $t['id'];
        }

        $item->tags()->sync($tids);

        return Redirect::action('NewsController@edit', ['id' => $item->id]);
    }

    public function edit($id)
    {
        $item = \services\News::getNewData($id);
        //$item = $this->getNewsItem($id);

        return View::make('news.edit', [
            'item' => $item,
        ]);
    }

    public function editProcess($id)
    {
        if (!$newsData = \services\News::getNewData($id)) {
            App::abort(404, 'News not found');
        }

        $newsData = array_merge((array) $newsData, Input::get('news'));

        $tags = Input::get('tags', []);
        if (!empty($tags)) {
            $tags = explode(',', $tags);
        }
        $newsData['tags'] = $tags;

        if ($photosCaptions = Input::get('photos_captions')) {
            $newsData['photosCaptions'] = $photosCaptions;
        }

        if ($photo = Input::file('photo')) {
            //$validate = $this->_validateImage(Input::get('photo'));
            //if (!$validate->passes()) {
            //    return Redirect::back()->withErrors($validate)->withInput();
            //}

            $newsData['photo'] = $photo;
        }

        if ($removePhotos = Input::get('remove_photos')) {
            \services\News::removePhotos($id, array_keys($removePhotos));
        }

        \services\News::setNewData($id, $newsData);

        return Redirect::back();
    }

    private function _validateImage($image)
    {
        $images = [
            'main_image' => $image,
        ];

        $rules = [
            'main_image' => 'image',
        ];

        $messages = [];

        return Validator::make($images, $rules, $messages);
    }

    private function _uploadImageForPost($postItem, $imageFile)
    {
        if (empty($imageFile)) {
            return false;
        }

        // TODO: optimize storage for images. Remove this simplified uploader
        $destinationPath = $this->upload_dir.$postItem->id.'/'; // The destination were you store the image.
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath);
        }

        return $imageFile->move($destinationPath, 'main_image.jpg'); // Now we move the file to its new home.
    }

    private function _removeImageForPost($postItem)
    {
        return File::delete($this->upload_dir.$postItem->id.'/'.'main_image.jpg');
    }
}
