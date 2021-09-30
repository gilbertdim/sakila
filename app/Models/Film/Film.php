<?php

namespace App\Models\Film;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $primaryKey = 'film_id';
    public $timestamps = false;

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

    public function language()
    {
        return $this->hasOne(\App\Models\Language::class, 'language_id', 'language_id');
    }

    public function originalLanguage()
    {
        return $this->hasOne(\App\Models\Language::class, 'language_id', 'original_language_id');
    }

    public function actors()
    {
        return $this->hasManyThrough(
            \App\Models\Actor::class,
            FilmActor::class, 
            'film_id',
            'actor_id',
            'film_id',
            'actor_id'
        );
    }

    public function categories()
    {
        return $this->hasOneThrough(
            \App\Models\Category::class,
            FilmCategory::class,
            'film_id',
            'category_id',
            'film_id',
            'category_id'
        );
    }

}
