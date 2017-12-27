<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;

class LoginController extends Controller
{
    //
	public function login(Request $request)
	{
		try{
			$validator = Validator::make($request->all(),[
				'username' => 'required|max:127',
				'password' => 'required|max:127'
			]);
			if($validator->fails())
			{
				$errors[]=[
					'title' => 'Invalid or Missing Parameters',
				];
				return  response([
					'errors' => $errors,
					'status' => 400,
				]);
			}
			else
			{
				$username = $request->input('username');
				$password = $request->input('password');
				$user = User::where('username','=',$username)->first();
				if($user)
				{
					if(password_verify($password,$user->password))
					{
						$message =  $user->name." has logged in";
						$status_code = 200;

						$token = password_hash($username.$password.env('API_SECRET'),PASSWORD_DEFAULT);
						$user->update(['token' => $token]);
						$data=[
							'token' => $token,
							'message' => $message
						];
						return  response([
							'data' => $data,
							'status' => 200,
						]);   	
					}
					else
					{
						$errors[]=[
							'title' => 'Invalid Credentials',
						];
						return  response([
							'errors' => $errors,
							'status' => 401,
						]);		
					}
				}
				else
				{
					$errors[]=[
						'title' => 'User not registered',
					];
					return  response([
						'errors' => $errors,
						'status' => 400,
					]);
				}
			}
		}
		catch(Exception $error)
		{
			$errors[]=[
				'title' => $error->getMessage(),
			];
			return  response([
				'errors' => $errors,
				'status' => 500,
			]);
		}
	}
	public function logout(Request $request)
	{    	
		try
		{	
			$token=$request->input('token');
			$user=User::where('token','=',$token)->first();
			$user->update(['token' => null ]);
			$message=$user->name." logged out";
			$data=[
				'message' => $message
			];
			return  response([
				'data' => $data,
				'status' => 200,
			]);    
		}
		catch(Exception $error)
		{
			$errors[]=[
				'title' => $error->getMessage(),
			];
			return  response([
				'errors' => $errors,
				'status' => 500,
			]);
		}
	}
}
