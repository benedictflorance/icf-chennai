<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    //

	protected $fillable=['rake_id','coach_num','type'];
    protected $hidden=['created_at','updated_at'];
}
