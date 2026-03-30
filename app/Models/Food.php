<?php

namespace App\Models;

use App\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'id',
        'category_id',
        'restaurant_id',
        'name',
        'price',
        'image',
        'description',
    ];
    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $timestamps = true;

    public function category()
    {
        if ($this->category_id) {
            return $this->Category::find($this->category_id);
        }
        return null;
    }
    public function sizes()
    {
        $conn = self::getConnection();

        $sql = "SELECT s.*
                FROM sizes s
                JOIN food_sizes fs ON fs.size_id = s.id
                WHERE fs.food_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);

        $results = [];
        while ($row = $stmt->fetch()) {
            $size = new Size();
            $size->fill($row);
            $size->exists = true;
            $results[] = $size;
        }
        return $results;
    }

    // lấy topping của món
    public function toppings()
    {
        $conn = self::getConnection();

        $sql = "SELECT t.*
                FROM toppings t
                JOIN food_toppings ft ON ft.topping_id = t.id
                WHERE ft.food_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->id]);

        $results = [];
        while ($row = $stmt->fetch()) {
            $topping = new Topping();
            $topping->fill($row);
            $topping->exists = true;
            $results[] = $topping;
        }
        return $results;
    }
}
