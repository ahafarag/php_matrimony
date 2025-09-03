<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function caste(){
        return $this->hasOne(Caste::class,'religion_id','id');
    }

}
