<?php
namespace App\Models;

use App\Model;

class Size extends Model
{
    protected $table = 'sizes';
    protected $fillable = [
        'id',
        'name',
        'price',
    ];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}