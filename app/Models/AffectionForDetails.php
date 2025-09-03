<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AffectionForDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    protected $casts = [
        'affection_id' => 'object'
    ];

    public function affectionFor()
    {
        return $this->belongsTo(AffectionFor::class, 'affection_for_id');
    }

}
