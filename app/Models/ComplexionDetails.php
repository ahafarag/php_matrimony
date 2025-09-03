<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComplexionDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function complexion(){
        return $this->belongsTo(Complexion::class, 'complexion_id', 'id');
    }

}
