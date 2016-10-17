<?php

class PageSocial extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'page_social';
    protected $primaryKey = 'id';

    protected $fillable = ['facebook', 'twitter', 'google'];
}
