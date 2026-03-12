<?php

namespace App\Models;

use App\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
    ];
    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}
