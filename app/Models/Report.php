<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function userReportedTo(){
        return $this->belongsTo(User::class, 'member_id','id');
    }

    public function userReportedBy(){
        return $this->belongsTo(User::class, 'user_id','id');
    }

}
