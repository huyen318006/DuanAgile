<?php 
namespace App\Models;

use App\Model;
use App\Models;
class CatePost extends Model {
    protected $table='catepost';
    protected $fillable = ['id','name','description','status','created_at','updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $timestamps = true;
}