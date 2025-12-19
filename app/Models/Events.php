<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'categories',
        'place',
        'url_image',
        'status',
        'start',
        'end',
    ];
}
