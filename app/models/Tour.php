<?php

class Tour extends Eloquent
{
    protected $table = 'tours';
    protected $primaryKey = 'id';
    protected $fillable = ['tour_description', 'tour_name'];

    public function information()
    {
        return $this->hasMany('Information');
    }

    public function icon()
    {
        return $this->hasMany('Icon');
    }
}
