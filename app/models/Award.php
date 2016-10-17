<?php

class Award extends Eloquent
{
    protected $fillable = ['user_id', 'title', 'slug', 'short_content', 'content', 'is_draft', 'domain'];

    protected $softDelete = true;

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function photos()
    {
        return $this->hasMany('AwardPhotos');
    }
}
