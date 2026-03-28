<?php
namespace App\Models;

use App\Model;

class Vocher extends Model
{
    protected $table = 'vocher';
    protected $fillable = [
        'user_id',
        'code',
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}