<?php

class J6Tour extends Eloquent
{
    protected $table = 'j6_tours';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'country',
        'state',
        'data',
    ];
}
