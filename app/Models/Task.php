<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'end_time',
    ];
//    protected $hidden =[
//        'user_id',
//        'created_at',
//        'update_at',
//    ];


    public function  user()
    {
        $this->belongsTo(User::class,'user_id');
    }
}
