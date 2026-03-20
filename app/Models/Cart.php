<?php

namespace App\Models;

use App\Model;
use App\Models\Users;
use App\Models\Food;
use App\Models\Size;
use App\Models\Topping;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'id',
        'user_id',
        'food_id',
        'quantity',
        'size_id',
        'topping_ids',
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

    public function size()
    {
        if ($this->size_id) {
            return Size::find($this->size_id);
        }
        return null;
    }

    public function getToppings()
    {
        if (empty($this->topping_ids)) return [];
        $ids = json_decode($this->topping_ids, true);
        if (!is_array($ids)) return [];
        $result = [];
        foreach ($ids as $id) {
            $t = Topping::find($id);
            if ($t) $result[] = $t;
        }
        return $result;
    }
}
