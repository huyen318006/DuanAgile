<?php
namespace App\Models;
use App\Model;
class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'food_id', 'size_id', 'topping_id', 'quantity', 'price'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $timestamps = false;
}

?>