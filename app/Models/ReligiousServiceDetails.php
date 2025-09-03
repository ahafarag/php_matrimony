<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReligiousServiceDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function religiousService(){
        return $this->belongsTo(ReligiousService::class, 'religious_service_id', 'id');
    }

}
