<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $primaryKey = 'address_id';
    protected $appends = [ 'city', 'country' ];
    public $timestamps = false;

    public function getCityAttribute()
    {
        return $this->cityRelation->city;
    }

    public function getCountryAttribute()
    {
        return $this->cityRelation->country->country;
    }

    public function cityRelation()
    {
        return $this->hasOne(City::class, 'city_id', 'city_id');
    }
}
