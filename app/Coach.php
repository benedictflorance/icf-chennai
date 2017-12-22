<?php

namespace App;
use App\Rake;
use App\CoachStatus;
use App\Position;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    //

	protected $fillable=['rake_id','coach_num','type'];
    protected $hidden=['created_at','updated_at'];
    public function rake()
    {
    	$this->belongsTo(Rake::class);
    }
    public function status()
    {
    	$this->hasOne(CoachStatus::class);
    }
    public function position()
    {
    	$this->hasOne(Position::class);
    }
}
