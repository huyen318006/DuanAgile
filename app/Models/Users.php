<?php
namespace App\Models;
use App\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone',
        'address',
        'created_at',
        'updated_at',
     
    ];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $timestamps = true;
}
?>