<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $fillable=['name','username','password','role','position','email','mobile','token'];
    protected $hidden=['id','password','created_at','updated_at','token'];
}
