<?php

use App\Http\Controllers\HeroesController;
use App\Http\Controllers\StoriesController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function() {
	Route::get('fetch-heroes', [HeroesController::class, 'fetchHeroes']);
	Route::get('heroes', [HeroesController::class, 'index']);
	Route::post('heroes', [HeroesController::class, 'store']);
	Route::get('heroes/{id}/stories', [StoriesController::class, 'index']);
});