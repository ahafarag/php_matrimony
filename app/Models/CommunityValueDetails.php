<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommunityValueDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function communityValue(){
        return $this->belongsTo(CommunityValue::class, 'community_value_id', 'id');
    }

}
