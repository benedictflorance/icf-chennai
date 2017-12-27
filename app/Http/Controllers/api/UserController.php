<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;

class UserController extends Controller
{
    //
    public function store(Request $request)
    {
    	 try{
                $validator = Validator::make($request->all(),[
                            'name' => 'required|max:127',
                            'username' => 'required|max:127',
                            'password' => 'required|max:127',
                            'role' => 'required|max:127',
                            'position' => 'required|max:127',
                            'email' => 'required|email|max:127',
                            'mobile' => 'required|digits:10|numeric',
                            'token' => 'required|max:60'
                ]);
                if($validator->fails())
                {
                    $errors = $validator->errors();
                    return response(["errors" => $errors,
                    "status" => 400]);
                }
                else
                {
                    $user=User::where('token','=',$request->input('token'))->first();
                    if($user->role=='admin')
                    {
                    	$user=User::create([
                                            'name' => $request->input('name'),
                                            'username' => $request->input('username'),
                                            'password' => password_hash($request->input('password'),PASSWORD_DEFAULT),
                                            'role' => $request->input('role'),
                                            'position' => $request->input('position'),
                                            'email' => $request->input('email'),
                                            'mobile' => $request->input('mobile'),    
                                        ]);
                        $message=$user->name." has been registered";
                        $data=['message' => $message];
                        $status=200;
                        return response(["data" => $data, "status" => $status]);
                   }
                   else
                   {
		                $errors[]=[
		                'title' => 'Unauthorized to add new users',
		                ];
		            	return  response([
		                'errors' => $errors,
		                'status' => 401,
		                ]);
                   }
                }
            }
        catch(Exception $error){
            $title = $error->getMessage();
            $errors[]=['title' => $title];
            return response(["errors" => $errors,
                "status" => 500]);
        }       
    }

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
