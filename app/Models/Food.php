<?php
namespace App\Models;

use App\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'id',
        'category_id',
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
        if($this->category_id){
            return $this->Category::find($this->category_id);
        }
        return null;
    }
}