<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shortUrl extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'originalUrl',
        'shortUrl',
        'createdAt'
    ];
    //
}
