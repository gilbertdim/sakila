<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $primaryKey = 'store_id';

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'store_id', 'store_id');
    }

    public function manager()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'manager_staff_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'address_id', 'address_id');
    }

    public function films()
    {
        return $this->hasMany(Film\Film::class, 'film_id', 'film_id');
    }
}
