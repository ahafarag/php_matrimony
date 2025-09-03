<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BodyTypeDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function bodyType(){
        return $this->belongsTo(BodyType::class, 'body_types_id', 'id');
    }

}
