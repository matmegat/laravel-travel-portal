<?php

class AwardPhotos extends Eloquent
{
    protected $fillable = ['award_id', 'is_primary'];

    public function award()
    {
        return $this->belongsTo('Award');
    }
}
