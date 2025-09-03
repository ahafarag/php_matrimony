<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnBehalf extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "on_behalves";

    public function language()
    {
        return $this->hasMany(Language::class, 'language_id', 'id');
    }

    public function details(){
        return $this->hasOne(OnBehalfDetails::class, 'on_behalf_id', 'id');
    }

}
