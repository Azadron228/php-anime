<?php

use App\Http\Controllers\Anime2Controller;
use App\Http\Controllers\Anime3Controller;
use App\Http\Controllers\AnimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//

Route::get('playlist/{id}', [Anime3Controller::class, 'playlist'])->name('register');
Route::get('search/{name}', [Anime3Controller::class, 'search'])->name('register');
Route::get('info/{id}', [Anime3Controller::class, 'info'])->name('register');
Route::get('last', [Anime3Controller::class, 'last'])->name('register');
Route::get('scrape', [Anime3Controller::class, 'scrape'])->name('register');


Route::get('all', [AnimeController::class, 'index'])->name('register');
Route::get('playlist/{id}', [AnimeController::class, 'playlist'])->name('register');
Route::get('search', [AnimeController::class, 'search'])->name('register');

