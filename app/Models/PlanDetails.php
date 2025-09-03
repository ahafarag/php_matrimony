<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanDetails extends Model
{
    use HasFactory, Translatable;

    protected $fillable = ['plan_id','language_id','name'];

    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }

}
