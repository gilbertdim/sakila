<?php

namespace App\Models\Film;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $primaryKey = 'film_id';

    protected static function booted()
    {
        static::created(function($film){
            $text = new FilmText;
            $text->film_id = $film->id;
            $text->title = $film->title;
            $text->description = $film->description;
            $text->save();
        });

        static::updated(function($film){
            $text = FilmText::find($film->id);
            $text->title = $film->title;
            $text->description = $film->description;
            $text->save();
        });

        static::deleted(function($film){
            FilmText::destroy($film->id);
        });
    }
}
