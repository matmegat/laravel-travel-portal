<?php

class AirportCodes extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'airport_codes';

    protected $fillable = ['name', 'iata_code', 'city_name', 'city_code', 'country_name'];
}
