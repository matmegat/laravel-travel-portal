<?php

class EAN_Policy extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'policydescriptionlist';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'EANHotelID';
}
