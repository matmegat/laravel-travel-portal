<?php

class EAN_RoomType extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roomtypelist';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = ['EANHotelID', 'RoomTypeID'];
}
