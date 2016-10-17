<?php

class News extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news';

    protected $fillable = ['user_id', 'title', 'slug', 'short_content', 'content', 'is_draft', 'domain'];

    protected $softDelete = true;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function tags()
    {
        return $this->belongsToMany('Tag');
    }

    public function photos()
    {
        return $this->hasMany('NewsPhotos');
    }
}
