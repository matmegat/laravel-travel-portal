<?php

class TravelTourLog extends Eloquent
{
    protected $table = 'travel_tour_logs';

    protected $guarded = [];

    public function getResultAttribute()
    {
        return unserialize($this->attributes['result']);
    }

    public function setResultAttribute($value)
    {
        $this->attributes['result'] = serialize($value);
    }
}
