<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;

class AdminController extends Controller
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

    public function editProfile(Request $request)
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
                    	$profile=User::where('username','=',$request->input('username'))->first();
                    	if($profile)
                    	{
	                    	$profile->update([
	                                            'name' => $request->input('name'),
	                                            'username' => $request->input('username'),
	                                            'password' => password_hash($request->input('password'),PASSWORD_DEFAULT),
	                                            'role' => $request->input('role'),
	                                            'position' => $request->input('position'),
	                                            'email' => $request->input('email'),
	                                            'mobile' => $request->input('mobile'),    
	                                        ]);
	                        $message=$profile->name." has been updated";
	                        $data=['message' => $message];
	                        return response(["data" => $data, "status" => 200]);
                    	}
                    	else
                    	{
                    	$errors[]=[
		                'title' => 'User does not exist',
		                ];
		            	return  response([
		                'errors' => $errors,
		                'status' => 400,
		                ]);

                    	}
                   }
                   else
                   {
		                $errors[]=[
		                'title' => 'Unauthorized to edit user profile',
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

 	public function getAllProfiles(Request $request)
 	{
 		try
 		{
                    $user=User::where('token','=',$request->input('token'))->first();
                    if($user->role=='admin')
                    {
                   		$users=User::all();
                   		return  response([
		                'data' => $users,
		                'status' => 200,
		                ]);
                    }
                   else
                   {
		                $errors[]=[
		                'title' => 'Unauthorized to get user profile',
		                ];
		            	return  response([
		                'errors' => $errors,
		                'status' => 401,
		                ]);
                   }
        }
            
        catch(Exception $error){
            $title = $error->getMessage();
            $errors[]=['title' => $title];
            return response(["errors" => $errors,
                "status" => 500]);
        }       
 	}

}
