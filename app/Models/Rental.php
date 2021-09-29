<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;
    protected $primaryKey = 'rental_id';

    protected static function booted()
    {
        static::created(function($rental){
            $rental->rental_date = now();
        });
    }
}
