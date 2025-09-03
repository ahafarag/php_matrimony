<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = ['price','status','icon','show_auto_profile_match','express_interest','express_interest_status','gallery_photo_upload','gallery_photo_upload_status','contact_view_info','contact_view_info_status',];

    public function language()
    {
        return $this->hasMany(Language::class, 'language_id', 'id');
    }

    public function details(){
        return $this->hasOne(PlanDetails::class);
    }

}
