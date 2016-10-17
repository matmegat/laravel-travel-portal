<?php

class EAN_Expect extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'whattoexpectlist';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'EANHotelID';
}
