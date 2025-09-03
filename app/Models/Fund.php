<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $guarded = ['id'];
    protected $table = "funds";

    protected $casts = [
        'detail' => 'object'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id');
    }

    public function planDetails()
    {
        return $this->belongsTo(PlanDetails::class, 'plan_id', 'plan_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function allPlan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

}
