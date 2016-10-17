<?php

class PageContact extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'page_contact';
    protected $primaryKey = 'id';

    protected $fillable = ['visitsname', 'phone', 'add_phone', 'email', 'address', 'city'];
}
