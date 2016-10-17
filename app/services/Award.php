<?php

namespace services;

class Award
{
    public $id;
    public $user_id;
    public $title;
    public $short_content;
    public $content;
    public $is_draft;
    public $primary_photo;
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

    public static function getAwardData($id)
    {
        $new = \Award::where('id', $id)
            ->withTrashed()
            ->with('photos')
            ->first();

        if (!$new) {
            return false;
        }

        return new self($new->toArray());
    }

    public static function getAwardBySlug($slug)
    {
        $new = \Award::where('slug', $slug)
            ->withTrashed()
            ->with('photos')
            ->first();

        if (!$new) {
            return false;
        }

        return new self($new->toArray());
    }

    public static function setAwardData($id, $data)
    {
        $new = \Award::where('id', '=', $id)->first();

        $new->title = $data['title'];
        $new->slug = \Str::slug($data['slug']);
        $new->is_draft = $data['is_draft'];
        $new->short_content = $data['short_content'];
        $new->content = $data['content'];
        $new->save();

        if (!empty($data['photosCaptions'])) {
            foreach ($data['photosCaptions'] as $photoId => $caption) {
                if ($photo = \AwardPhotos::find($photoId)) {
                    $photo->caption = $caption;
                    $photo->save();
                }
            }
        }

        // add photos to new
        if (isset($data['photo'])) {
            $photosCount = \AwardPhotos::where('award_id', '=', $new->id)->count();

            $photo = $data['photo'];
            if (!\File::exists(self::getPath($new->id))) {
                \File::makeDirectory(self::getPath($new->id), 664);
            }

            $newsPhoto = \AwardPhotos::create([
                'award_id' => $new->id,
                'is_primary' => !$photosCount,
            ]);

            $photo->move(self::getPath($new->id), self::getFileName($newsPhoto->id));
        }

        return true;
    }

    public static function getPath($newId, $photoId = false)
    {
        $folderPath = \Config::get('app.uploadDir').'/award/'.$newId;
        if ($photoId) {
            return $folderPath.'/'.self::getFileName($photoId);
        } else {
            return $folderPath;
        }
    }

    public static function getUrl($newId, $photoId)
    {
        return '/uploads/award/'.$newId.'/'.self::getFileName($photoId);
    }

    public static function removePhotos($newId, $photosIds)
    {
        \AwardPhotos::whereIn('id', $photosIds)
            ->where('award_id', '=', $newId)
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

    public static function findAwards(array $params = [])
    {
        $query = \Award::where('is_draft', '!=', 1);

        // filter by date
        if (!empty($params['date']['from'])) {
            $query->where('created_at', '>=', $params['date']['from']);
        }
        if (!empty($params['date']['to'])) {
            $query->where('created_at', '<=', $params['date']['to']);
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
            $results[$id] = self::getAwardData($id);
        }

        return $results;
    }

    public static function getArchives(array $params = [])
    {
        $query = \Award::select([
                \DB::raw('count(*) as count'),
                \DB::raw("DATE_FORMAT(created_at, '%Y-%m-01') as date"),
            ])
            ->where('is_draft', '!=', 1)
            ->groupBy('date');

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
