<?php

class TourPullQueue extends Eloquent
{
    protected $table = 'tour_pull_queue';
    protected $primaryKey = 'id';
    protected $fillable = [
        'from_id',
        'to_id',
    ];
}
