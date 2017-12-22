<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //
    protected $fillable=['coach_id','line','stage'];
    protected $hidden=['created_at','updated_at'];
}
