<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'payment_id';
    
    protected static function booted()
    {
        static::created(function ($payment){
            $payment->payment_date = now();
        });
    }
}
