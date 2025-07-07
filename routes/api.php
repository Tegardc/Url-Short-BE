<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;

Route::post('/shorten', [ShortUrlController::class, 'store']);
Route::get('/resolve/{code}', [ShortUrlController::class, 'resolve']);
