<?php


class AwardController extends BaseController
{
    protected $upload_dir;
    protected $upload_uri;

    public function __construct()
    {
        View::share('active_tab', 'award');
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        View::share('weekday', strtoupper(date('l')));

        $this->upload_uri = '/uploads/award/';
        $this->upload_dir = public_path().$this->upload_uri;

        View::share('upload_dir', $this->upload_dir);
        View::share('upload_uri', $this->upload_uri);
    }

    public function show($year, $slug)
    {
        $news = \services\Award::getAwardBySlug($slug);

        if ($news->deleted_at || $news->is_draft) {
            App::abort(404, 'Award not found');
        }

        return View::make('award.details', ['award' => $news]);
    }

    public function listAward()
    {
        $params['count'] = 10;
        $params['offset'] = (\Paginator::getCurrentPage() - 1) * $params['count'];

        if ($date = Input::get('date')) {
            $time = strtotime(Input::get('date'));
            $t = date('t', $time);

            $params['date']['from'] = date('Y-m-01', $time);
            $params['date']['to'] = date("Y-m-{$t}", $time);
        }

        $news = \Paginator::make(\services\Award::findAwards($params), \services\Award::getTotalDisplayRecords(), $params['count']);

        $header = $this->headerConfig();

        return View::make('award.list', [
            'award' => $news,
            'header' => $header,
        ]);
    }

    private function headerConfig()
    {
        return [
            'title' => DBconfig::get('page.award_header', 'Awards'),
            'background' => file_exists(public_path($this->upload_uri.'header.png'))
                ? $this->upload_uri.'header.png'
                : $this->upload_uri.'default-header.jpg' ,
        ];
    }
}
