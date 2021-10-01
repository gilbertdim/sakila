<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('films', [ \App\Http\Controllers\FilmsController::class, 'list' ]);
Route::get('films/search', [ \App\Http\Controllers\FilmsController::class, 'search' ]);

Route::get('film/{film_id}/actors', [ \App\Http\Controllers\FilmsController::class, 'film_actors' ]);

Route::get('actors', [ \App\Http\Controllers\ActorsController::class, 'list' ]);
Route::get('actors/search', [ \App\Http\Controllers\ActorsController::class, 'search' ]);

Route::get('actor/{actor_id}/films', [ \App\Http\Controllers\ActorsController::class, 'actor_films' ]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
