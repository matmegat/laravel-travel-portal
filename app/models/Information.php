<?php

class Information extends Eloquent
{
    protected $table = 'tour_information';
    protected $primaryKey = 'id';
    protected $fillable = ['content'];
}
