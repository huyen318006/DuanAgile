<?php
namespace App\Models;

use App\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'receiver',
        'phone',
        'address',
        'note',
        'total_price',
        'status',
        'payment_method',
        'receiver',
        'phone',
        'created_at',
        'updated_at'
    ];
    protected $guarded = ['id'];
    protected $timestamps = true;
   

}