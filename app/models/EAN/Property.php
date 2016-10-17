<?php

class EAN_Property extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activepropertylist';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'EANHotelID';

    public function images()
    {
        return $this->hasMany('EAN_Image', 'EANHotelID');
    }

    public function attributes()
    {
        return $this->hasMany('EAN_AttributeLink', 'EANHotelID');
    }
}
