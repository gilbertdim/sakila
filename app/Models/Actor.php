<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;
    protected $primaryKey = 'actor_id';
    public $timestamps = false;
    public $appends = [ 'fullname' ];
    
    public function getFullnameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    public function films()
    {
        return $this->hasManyThrough(
            \App\Models\Film\Film::class,
            \App\Models\Film\FilmActor::class,
            'actor_id',
            'film_id',
            'actor_id',
            'film_id'
        );
    }
}
