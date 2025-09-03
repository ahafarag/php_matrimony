<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EthnicityDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function ethnicity(){
        return $this->belongsTo(Complexion::class, 'ethnicity_id', 'id');
    }

}
