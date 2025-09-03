<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Translatable;

class HairColorDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function hairColor(){
        return $this->belongsTo(HairColor::class, 'hair_color_id', 'id');
    }

}
