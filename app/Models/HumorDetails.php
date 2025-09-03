<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HumorDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    protected $casts = [
        'humor' => 'object'
    ];

    public function humor(){
        return $this->belongsTo(Humor::class, 'humor_id', 'id');
    }

}
