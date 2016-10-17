<?php

class Tag extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

    protected $fillable = ['text', 'domain'];

    protected $visible = ['id', 'text'];

    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function news()
    {
        return $this->belongsToMany('News');
    }
}
