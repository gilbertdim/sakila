<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'customer_id';
    
    protected static function booted()
    {
        static::created(function ($customer){
            $customer->create_date = now();
        });
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'address_id', 'address_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'customer_id', 'customer_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'customer_id', 'customer_id');
    }
}
