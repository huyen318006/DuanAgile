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
        'product_id',
        'total_price',
        'status',
        'payment_method',
        'created_at',
    ];
    protected $guarded = ['id'];
   

}