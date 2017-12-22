<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Coach;

class Position extends Model
{
    //
    protected $fillable=['coach_id','line','stage'];
    protected $hidden=['created_at','updated_at'];
    public function coach()
    {
    	$this->belongsTo(Coach::class);
    }
}
