<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyValueDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function familyValue(){
        return $this->belongsTo(FamilyValue::class, 'family_values_id', 'id');
    }
}
