<?php

class EAN_AttributeLink extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'propertyattributelink';

    protected $hidden = ['EANHotelID', 'TimeStamp', 'LanguageCode'];

    protected $with = ['attribute'];
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'AttributeID';

    public function attribute()
    {
        return $this->hasOne('EAN_Attribute', 'AttributeID');
    }
}
