<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

use App\Models\Actor;

class ActorsController extends Controller
{
    public function list()
    {
        $per_page = 15;
        if(request()->has('per_page')) $per_page = request()->query('per_page');

        $actors = Cache::store('redis')->get("api-actors-".(request()->query('page')??1));
        if(!$actors)
        {
            $actors = Actor::select('actor_id', 'first_name', 'last_name')
                ->simplePaginate($per_page);
                
            Cache::store('redis')->put("api-actors-".(request()->query('page')??1), $actors, 120);
        }

        return response()->json($actors);
    }

    public function search()
    {
        if(!request()->has('keyword') && !request()->has('first_name') && !request()->has('last_name'))
        {
            return response()->json([
                'message' => 'no search criteria',
                'criteria' => [
                    'keyword',
                    'first_name',
                    'last_name',
                ]
            ], 400);
        }

        $per_page = 15;
        $url_query = Arr::query(request()->query());
        if(request()->has('per_page')) $per_page = request()->query('per_page');

        $actors = Cache::store('redis')->get("api-actors-search-$url_query");
        if(!$actors)
        {
            $actors = Actor::select('actor_id', 'first_name', 'last_name');
            
            if(request()->has('keyword'))
            {
                $keyword = request()->query('keyword');
                $actors->where(function($query) use ($keyword) {
                    $query->where('first_name', 'like', "%$keyword%");
                    $query->orwhere('last_name', 'like', "%$keyword%");
                });
            }
            
            if(request()->has('first_name')) $actors->where('first_name', 'like', '%'.request()->query('first_name').'%');
            if(request()->has('last_name')) $actors->where('last_name', 'like', '%'.request()->query('last_name').'%');

            $actors = $actors->paginate($per_page);

            Cache::store('redis')->put("api-actors-search-$url_query", $actors, 120);
        }

        return response()->json($actors);
    }

    public function actor_films($actor_id)
    {
        $actor = Actor::find($actor_id);

        if(!$actor)
        {
            return response()->json([
                'message' => 'Actor not found',
            ], 404);
        }

        $films = Cache::store('redis')->get("api-actor-films-$actor_id");
        if(!$films)
        {
            $films = $actor->films->makeHidden([
                "language_id",
                "original_language_id",
                "rental_duration",
                "rental_rate",
                "replacement_cost",
                "special_features",
                "last_update",
                "laravel_through_key",
            ]);

            Cache::store('redis')->put("api-actor-films-$actor_id", $films, 120);
        }

        return response()->json($films);
    }
}
