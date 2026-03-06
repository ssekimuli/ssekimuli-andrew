<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
Route::get('/search', [ProfileController::class, 'search']);
Route::get('/scrape/{username}', [ProfileController::class,'scrape']);
Route::get('/test-scrape/{username}', [ProfileController::class,'scrape']);

