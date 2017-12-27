<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;

class UserController extends Controller
{
    //
    public function getProfile(Request $request)
    {
    	try{
            $token=$request->input('token');
            $user=User::where('token','=',$token)->first();
            return response([
            	'data' => $user,
            	'status' => 200
            ]);

        }
        catch(Exception $error){
            $title = $error->getMessage();
            $errors[]=['title' => $title];
            return response(["errors" => $errors,
                "status" => 500]);
        }
    }
}
