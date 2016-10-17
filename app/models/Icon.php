<?php

class Icon extends Eloquent
{
    protected $table = 'tour_icons';
    protected $primaryKey = 'id';
    protected $fillable = ['icon', 'tour_id'];

    public function allicon()
    {
        return $this->hasOne('AllIcons', 'id', 'icon');
    }
}
