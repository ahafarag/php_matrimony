<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caste extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function subCaste()
    {
        return $this->hasOne(SubCaste::class, 'caste_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }
}
