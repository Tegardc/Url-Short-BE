<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/{code}', [ShortUrlController::class, 'redirect'])
    ->where('code', '[0-9a-zA-Z]+');
