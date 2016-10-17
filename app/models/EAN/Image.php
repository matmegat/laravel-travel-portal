<?php

class EAN_Image extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hotelimagelist';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'URL';
}
