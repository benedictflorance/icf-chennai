<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Coach;

class Rake extends Model
{
    //
    protected $fillable=['railway','rake_num'];
    protected $hidden=['created_at','updated_at'];
    public function coaches()
    {
    	return $this->hasMany(Coach::class);
    }
}
