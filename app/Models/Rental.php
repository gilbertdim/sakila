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

    public function payment()
    {
        return $this->hasOne(Payment::class, 'rental_id', 'rental_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'staff_id');
    }
}
