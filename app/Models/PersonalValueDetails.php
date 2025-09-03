<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalValueDetails extends Model
{
    use HasFactory;

    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function personalValue(){
        return $this->belongsTo(PersonalValue::class, 'personal_value_id', 'id');
    }

}
