<?php

class PageName extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'page_name';
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public $timestamps = false;
}
