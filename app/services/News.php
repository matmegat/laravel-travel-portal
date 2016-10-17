<?php

namespace services;

class News
{
    public $id;
    public $user_id;
    public $title;
    public $short_content;
    public $content;
    public $is_draft;
    public $primary_photo;
    public $domain;
    public $tags;
    public $photos;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public $user;

    private static $totalDisplayRecords;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->user_id = $data['user_id'];
        $this->title = $data['title'];
        $this->slug = $data['slug'];
        $this->short_content = $data['short_content'];
        $this->content = $data['content'];
        $this->is_draft = $data['is_draft'];
        $this->domain = $data['domain'];
        $this->tags = $data['tags'];
        $this->photos = $data['photos'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->deleted_at = $data['deleted_at'];

        foreach ($this->photos as &$photo) {
            $photo['url'] = self::getUrl($this->id, $photo['id']);
            if ($photo['is_primary']) {
                $this->primary_photo = $photo;
            }
        }

        $this->user = \User::find($data['user_id']);
    }

    public function getTagsTexts()
    {
        $result = [];
        foreach ($this->tags as $tag) {
            $result[] = $tag['text'];
        }

        return $result;
    }

    public function getPhotos()
    {
        $result = [];
        foreach ($this->photos as $photo) {
            $result[] = [
                'id' => $photo['id'],
                'is_primary' => $photo['is_primary'],
                'caption' => $photo['caption'],
                'url' => self::getUrl($this->id, $photo['id']),
            ];
        }

        return $result;
    }

    public static function getNewData($id)
    {
        $new = \News::where('domain', \Config::get('site.domain'))
            ->where('id', $id)
            ->withTrashed()
            ->with('tags')
            ->with('photos')
            ->first();

        if (!$new) {
            return false;
        }

        return new self($new->toArray());
    }

    public static function getNewsBySlug($slug)
    {
        $new = \News::where('domain', \Config::get('site.domain'))
            ->where('slug', $slug)
            ->withTrashed()
            ->with('tags')
            ->with('photos')
            ->first();

        if (!$new) {
            return false;
        }

        return new self($new->toArray());
    }

    public static function setNewData($id, $data)
    {
        $new = \News::where('id', '=', $id)->first();

        $new->title = $data['title'];
        $new->slug = \Str::slug($data['slug']);
        $new->is_draft = $data['is_draft'];
        $new->short_content = $data['short_content'];
        $new->content = $data['content'];
        $new->save();

        // add tags to new
        $tagsIds = [];
        if (!empty($data['tags'])) {
            $data['tags'] = array_filter($data['tags']);
            $data['tags'] = array_map('strtolower', $data['tags']);
            $data['tags'] = array_map('trim', $data['tags']);

            foreach ($data['tags'] as $tagText) {
                $tag = \Tag::where('domain', '=', \Config::get('site.domain'))
                    ->where('text', '=', $tagText)
                    ->first();

                if (!$tag) {
                    $tag = \Tag::create([
                        'text' => $tagText,
                        'domain' => \Config::get('site.domain'),
                    ]);
                }

                $tagsIds[] = $tag->id;
            }
        }
        $new->tags()->sync($tagsIds);

        if (!empty($data['photosCaptions'])) {
            foreach ($data['photosCaptions'] as $photoId => $caption) {
                if ($photo = \NewsPhotos::find($photoId)) {
                    $photo->caption = $caption;
                    $photo->save();
                }
            }
        }

        // add photos to new
        if (isset($data['photo'])) {
            $photosCount = \NewsPhotos::where('news_id', '=', $new->id)->count();

            $photo = $data['photo'];
            if (!\File::exists(self::getPath($new->id))) {
                \File::makeDirectory(self::getPath($new->id), 664);
            }

            $newsPhoto = \NewsPhotos::create([
                'news_id' => $new->id,
                'is_primary' => !$photosCount,
            ]);

            $photo->move(self::getPath($new->id), self::getFileName($newsPhoto->id));
        }

        return true;
    }

    public static function getPath($newId, $photoId = false)
    {
        $folderPath = \Config::get('app.uploadDir').'/news/'.$newId;
        if ($photoId) {
            return $folderPath.'/'.self::getFileName($photoId);
        } else {
            return $folderPath;
        }
    }

    public static function getUrl($newId, $photoId)
    {
        return '/uploads/news/'.$newId.'/'.self::getFileName($photoId);
    }

    public static function removePhotos($newId, $photosIds)
    {
        \NewsPhotos::whereIn('id', $photosIds)
            ->where('news_id', '=', $newId)
            ->delete();

        foreach ($photosIds as $photoId) {
            $path = self::getPath($newId, $photoId);

            if (file_exists($path) && !is_dir($path)) {
                unlink($path);
            }
        }
    }

    private static function getFileName($photoId)
    {
        return $photoId.'.png';
    }

    public static function storeNewsView($newsId, $ip)
    {
        $newsView = new \NewsView([
            'news_id' => $newsId,
            'ip' => $ip,
        ]);
        $newsView->save();
    }

    public static function getPopularNews($count)
    {
        $results = [];

        foreach (\NewsView::getPopular($count) as $new) {
            $results[] = self::getNewData($new->id);
        }

        return $results;
    }

    public static function findNews(array $params = [])
    {
        $query = \News::where('is_draft', '!=', 1);

        // filter by date
        if (!empty($params['date']['from'])) {
            $query->where('created_at', '>=', $params['date']['from']);
        }
        if (!empty($params['date']['to'])) {
            $query->where('created_at', '<=', $params['date']['to']);
        }

        // filter by tag
        if (!empty($params['tag'])) {
            $tag = $params['tag'];
            $query->has('tags', '>=', 1, 'and', function ($q) use ($tag) {
                return $q->where('id', '=', $tag);
            });
        }

        // filter by query
        if (!empty($params['query'])) {
            $query->whereRaw('MATCH(title, short_content, content) AGAINST(? IN BOOLEAN MODE)', [$params['query']]);
        }

        $query->orderBy('created_at', 'desc');

        self::$totalDisplayRecords = $query->count();

        if (!empty($params['count'])) {
            $query->take($params['count']);
        }
        if (!empty($params['offset'])) {
            $query->offset($params['offset']);
        }

        $ids = $query->lists('id');

        $results = [];
        foreach ($ids as $id) {
            $results[$id] = self::getNewData($id);
        }

        return $results;
    }

    public static function findTags(array $params = [])
    {
        return \Tag::has('news', '>=', 1, 'and', function ($q) use ($params) {
            $q->where('is_draft', '=', 0);
            $q->where('domain', \Config::get('site.domain'));
            $q->where('text', '!=', '');

            if (!empty($params['date']['from'])) {
                $q->where('created_at', '>=', $params['date']['from']);
            }
            if (!empty($params['date']['to'])) {
                $q->where('created_at', '<=', $params['date']['to']);
            }

            return $q;
        })->get();
    }

    public static function getArchives(array $params = [])
    {
        $query = \News::select([
                \DB::raw('count(*) as count'),
                \DB::raw("DATE_FORMAT(created_at, '%Y-%m-01') as date"),
            ])
            ->where('is_draft', '!=', 1)
            ->groupBy('date');

        if (!empty($params['tag'])) {
            $tag = $params['tag'];
            $query->has('tags', '>=', 1, 'and', function ($q) use ($tag) {
                return $q->where('id', '=', $tag);
            });
        }

        $data = $query->get();

        $results = [];
        foreach ($data as $item) {
            $results[] = $item->getAttributes();
        }

        return $results;
    }

    public static function getTotalDisplayRecords()
    {
        return self::$totalDisplayRecords;
    }
}
