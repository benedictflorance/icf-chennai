<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rake extends Model
{
    //
    protected $fillable=['railway','rake_num'];
    protected $hidden=['created_at','updated_at'];
}
