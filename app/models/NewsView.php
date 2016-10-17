<?php

class NewsView extends Eloquent
{
    protected $table = 'news_views';

    protected $fillable = [
        'news_id',
        'ip',
    ];

    public function news()
    {
        return $this->hasOne('New');
    }

    public static function getPopular($count)
    {
        $query = self::select()
            ->select(DB::raw('count(*) as viewsCount, news_id'))
            ->groupBy('news_id')
            ->orderBy('viewsCount')
            ->take($count);

        $results = $query->get();
        if (empty($results)) {
            return [];
        }

        $ids = [];
        foreach ($results as $result) {
            $ids[] = (int) $result['news_id'];
        }

        return \News::findMany($ids);
    }
}
