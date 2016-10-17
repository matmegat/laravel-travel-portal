<?php

class TravelTour extends \Jenssegers\Mongodb\Model
{
    protected $connection = 'mongodb';
    protected $collection = 'travel_tours';
}

//class TravelTour extends Eloquent
//{
//    protected $table = 'travel_tours';
//
//    protected $primaryKey = '_id';
//
//    protected $guarded = array();
//
//    public function getImagesAttribute()
//    {
//        return unserialize($this->attributes['images']);
//    }
//    public function setImagesAttribute($value)
//    {
//        $this->attributes['images'] = serialize($value);
//    }
//
//    public function getDataAttribute()
//    {
//        return unserialize($this->attributes['data']);
//    }
//    public function setDataAttribute($value)
//    {
//        $this->attributes['data'] = serialize($value);
//    }
//}
