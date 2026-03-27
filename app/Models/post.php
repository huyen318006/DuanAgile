<?php

namespace App\Models; 
use App\Model;
class Post extends Model
{
    protected $table = "posts";
    protected $fillable = ['id','title', 'content', 'image','author','views','status','cate_id','created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected  $guarded = ['id'];
    protected $timestamps = true;
}
?>