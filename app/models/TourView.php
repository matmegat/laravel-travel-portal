<?php

class TourView extends Eloquent
{
    protected $table = 'tours_views';

    protected $fillable = [
        'tour_id',
        'ip',
        'api',
    ];

    public function tour()
    {
        return $this->hasOne('Tour');
    }

    public static function getPopularIds($count, $api = false)
    {
        $ids = [];

        $query = self::select()
            ->select(DB::raw('count(*) as viewsCount, tour_id'))
            ->groupBy('tour_id')
            ->orderBy('viewsCount')
            ->take($count);

        if ($api) {
            $query->where('api', '=', $api);
        }

        $results = $query->get();

        foreach ($results as $result) {
            $ids[] = (int) $result['tour_id'];
        }

        return $ids;
    }

    public static function getPopular($count, $api = false)
    {
        $query = self::select()
            ->select(DB::raw('count(*) as viewsCount, tour_id, api'))
            ->groupBy('tour_id')
            ->orderBy('viewsCount')
            ->take($count);

        if ($api) {
            $query->where('api', '=', $api);
        }

        $data = $query->get();

        $results = [];
        foreach ($data as $item) {
            $results[] = [
                'id' => (int) $item['tour_id'],
                'api' => $item['api'],
                'count' => $item['viewsCount'],
            ];
        }

        return $results;
    }
}
