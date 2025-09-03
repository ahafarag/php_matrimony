<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BodyArtDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function bodyArt(){
        return $this->belongsTo(BodyArt::class, 'body_art_id', 'id');
    }

}
