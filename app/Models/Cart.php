<?php

namespace App\Models;

use App\Model;
use App\Models\Users;
use App\Models\Food;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'id',
        'user_id',
        'food_id',
        'quantity'
    ];
    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $timestamps = false;

    public function user()
    {
        if ($this->user_id) {
            return Users::find($this->user_id);
        }
        return null;
    }

    public function food()
    {
        if ($this->food_id) {
            return Food::find($this->food_id);
        }
        return null;
    }
}
