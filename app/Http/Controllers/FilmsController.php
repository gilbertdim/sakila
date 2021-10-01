<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

use App\Models\Film\Film;

class FilmsController extends Controller
{
    public function list()
    {
        $per_page = 15;
        if(request()->has('per_page')) $per_page = request()->query('per_page');

        $films = Cache::store('redis')->get("api-films-".(request()->query('page')??1));
        if(!$films)
        {
            $films = Film::select('film_id', 'title', 'description', 'release_year', 'length', 'rating')
                ->simplePaginate($per_page);
                
            Cache::store('redis')->put("api-films-".(request()->query('page')??1), $films, 120);
        }

        return response()->json($films);
    }

    public function search()
    {
        if(!request()->has('keyword') 
            && !request()->has('title')
            && !request()->has('description')
            && !request()->has('release_year')
            && !request()->has('rating')
            && !request()->has('length'))
        {
            return response()->json([
                'message' => 'no search criteria',
                'criteria' => [
                    'keyword',
                    'title',
                    'description',
                    'release_year',
                    'rating',
                    'length',
                ]
            ], 400);
        }

        $per_page = 15;
        $url_query = Arr::query(request()->query());
        if(request()->has('per_page')) $per_page = request()->query('per_page');

        $films = Cache::store('redis')->get("api-films-search-$url_query");
        if(!$films)
        {
            $films = Film::select('film_id', 'title', 'description', 'release_year', 'length', 'rating');
            
            if(request()->has('keyword'))
            {
                $keyword = request()->query('keyword');
                $films->where(function($query) use ($keyword) {
                    $query->where('title', 'like', "%$keyword%");
                    $query->orwhere('description', 'like', "%$keyword%");
                    $query->orwhere('release_year', 'like', "%$keyword%");
                    $query->orwhere('rating', 'like', "%$keyword%");
                });
            }
            
            if(request()->has('title')) $films->where('title', 'like', '%'.request()->query('title').'%');
            if(request()->has('description')) $films->where('description', 'like', '%'.request()->query('description').'%');
            if(request()->has('release_year')) $films->where('release_year', request()->query('release_year'));
            if(request()->has('rating')) $films->where('rating', request()->query('rating'));
            if(request()->has('length')) $films->where('length', request()->query('length'));

            $films = $films->paginate($per_page);

            Cache::store('redis')->put("api-films-search-$url_query", $films, 120);
        }

        return response()->json($films);
    }

    public function film_actors($film_id)
    {
        $film = Film::find($film_id);

        if(!$film)
        {
            return response()->json([
                'message' => 'film not found',
            ], 404);
        }

        $actors = Cache::store('redis')->get("api-films-actors-$film_id");
        if(!$actors)
        {
            $actors = $film->actors
                ->makeHidden([
                    'last_update', 'laravel_through_key'
                ]);

            Cache::store('redis')->put("api-films-actors-$film_id", $actors, 120);
        }

        return response()->json($actors);
    }
}
