<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;

Route::post('/shorten', [ShortUrlController::class, 'store']);
// Route::get('/resolve/{code}', [ShortUrlController::class, 'resolve']);

Route::get('/resolve/{code}', function ($code) {
    $url = \App\Models\shortUrl::where('shortUrl', $code)->first();

    if (!$url) {
        return response()->json(['error' => 'Not found'], 404);
    }

    return response()->json(['originalUrl' => $url->originalUrl]);
});
