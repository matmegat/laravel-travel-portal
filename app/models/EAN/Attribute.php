<?php

class EAN_Attribute extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attributelist';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'AttributeID';
}
