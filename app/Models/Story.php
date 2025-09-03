<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'gallery' =>'object',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }

}
