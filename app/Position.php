<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Coach;

class Position extends Model
{
    //
    protected $fillable=['coach_id','linename','lineno','stage'];
    protected $hidden=['id','coach_id','created_at','updated_at'];
    public function coach()
    {
    	return $this->belongsTo(Coach::class);
    }
}
