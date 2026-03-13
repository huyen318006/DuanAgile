<?php

namespace App\Models;

use App\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';

    protected $fillable = [
        'id',
        'name',
        'logo',
        'image',
        'address',
        'rating',
        'status',
        'created_at',
        'updated_at',
        'slogan',
        'discount',
    ];
    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $timestamps = true;
}
