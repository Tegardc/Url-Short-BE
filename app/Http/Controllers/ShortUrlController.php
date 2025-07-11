<?php

namespace App\Http\Controllers;

use App\Models\shortUrl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    protected $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

     private function base62_encode($num): string
    {
        $base = strlen($this->characters);
        $result = '';
        while ($num > 0) {
            $result = $this->characters[$num % $base] . $result;
            $num = intdiv($num, $base);
        }
        return $result;
    }

    /**
     * Display a listing of the resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...
            $request->validate([
                'originalUrl' => 'required|url',
            ]);
            $shortUrl = shortUrl::create([
                'originalUrl' => $request->originalUrl,
                'shortUrl' => '',
                'createdAt' => now(),

            ]);
            $code = $this->base62_encode($shortUrl->id);

            $shortUrl->shortUrl = $code;
            $shortUrl->save();
            $baseUrl = config('app.url');

            return response()->json([
                'originalUrl' => $shortUrl->originalUrl,
                'shortUrl' => $baseUrl . '/' . $shortUrl->shortUrl
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


        //
    }
    public function resolve($code)
{
    $data = ShortUrl::where('shortUrl', $code)->firstOrFail();

    return response()->json([
        'originalUrl' => $data->originalUrl
    ]);
}

    /**
     * Display the specified resource.
     */

    public function redirect($code)
    {
        $data = shortUrl::where('shortUrl', $code)->firstOrFail();
        return redirect($data->originalUrl);
    }
}
