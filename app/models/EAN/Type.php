<?php

class EAN_Type extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'propertytypelist';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'PropertyCategory';
}
