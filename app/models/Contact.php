<?php

class Contact extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'page_contact';
    protected $primaryKey = 'id';

    protected $fillable = ['text_preview', 'address', 'country', 'city', 'phone', 'add_phone', 'email'];
}
