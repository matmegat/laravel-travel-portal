<?php

class NewsPhotos extends Eloquent
{
    protected $table = 'news_photos';

    protected $fillable = ['news_id', 'is_primary'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function news()
    {
        return $this->belongsTo('News');
    }
}
