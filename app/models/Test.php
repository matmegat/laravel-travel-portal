<?php

class Test_test extends Eloquent
{
    protected $table = 'tour_information';
    protected $primaryKey = 'id';

    public function tour()
    {
        return $this->belongsTo('Tour');
    }
}
