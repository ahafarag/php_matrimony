<?php

namespace App\Models;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoliticalViewDetails extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public function politicalView(){
        return $this->belongsTo(PoliticalView::class, 'political_view_id', 'id');
    }

}
