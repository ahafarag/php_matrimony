<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Translatable;

class OnBehalfDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    protected $table = "on_behalf_details";

    public function onBehalf(){
        return $this->belongsTo(OnBehalf::class, 'on_behalf_id', 'id');
    }
}
