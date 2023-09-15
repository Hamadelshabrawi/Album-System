<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/', [\App\Http\Controllers\DashboardController::class,'index']);


    Route::resource('albums', AlbumController::class);
    Route::get('album_edit/{id}', [AlbumController::class,'album_edit']);
    Route::get('show_albbum/{id}', [AlbumController::class,'show_albbum']);

    Route::post('transform/{id}', [AlbumController::class,'transform'])->name('albums.remove');
    Route::get('delete/{id}', [AlbumController::class,'delete'])->name('albumsRemove');



});
