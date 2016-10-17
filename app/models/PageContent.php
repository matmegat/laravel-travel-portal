<?php

class PageContent extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'page_content';
    protected $primaryKey = 'id';

    protected $fillable = ['page_id', 'title', 'content', 'backgroundUrl'];

    public function tours()
    {
        return $this->hasMany('PageTour', 'page_id', 'page_id');
    }
}
