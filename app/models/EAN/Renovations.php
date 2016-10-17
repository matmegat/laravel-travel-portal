<?php

class EAN_Renovations extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'propertyrenovationslist';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'EANHotelID';
}
