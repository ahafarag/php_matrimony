<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatusDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function maritalStatus(){
        return $this->belongsTo(MaritalStatus::class, 'marital_status_id', 'id');
    }

}
