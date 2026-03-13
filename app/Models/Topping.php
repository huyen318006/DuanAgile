<?php
namespace App\Models;

use App\Model;

class Topping extends Model
{
    protected $table = 'toppings';
    protected $fillable = [
        'id',
        'name',
        'price',
    ];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}