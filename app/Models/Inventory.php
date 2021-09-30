<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $primaryKey = 'inventory_id';
    public $timestamps = false;

    public function rental()
    {
        return $this->hasOne(Rental::class, 'inventory_id', 'inventory_id');
    }

    public function film()
    {
        return $this->hasOne(Film\Film::class, 'film_id', 'film_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }
}
