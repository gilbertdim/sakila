<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $primaryKey = 'city_id';
    public $timestamps = false;

    public function country()
    {
        return $this->hasOne(Country::class, 'city_id', 'city_id');
    }
}
