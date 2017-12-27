<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Rake;
use App\User;

class RakeController extends Controller
{
    //
	public function store(Request $request)
	{
		try{
			$validator = Validator::make($request->all(),[
				'railway' => 'required|max:15',
				'rake_num' => 'required|max:15'
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
				if($user->role == 'write' || $user->role == 'admin')
				{
					$rake=Rake::create([
						'railway' => $request->input('railway'),
						'rake_num' => $request->input('rake_num') 
					]);
					$message=$rake->rake_num." has been added";
					$data=['message' => $message];
					$status=200;
					return response(["data" => $data, "status" => $status]);
				}
				else
				{
					$errors[]=[
						'title' => 'Unauthorized to add new rakes',
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
	public function getAll(Request $request)
	{
		try
		{ 
			$rakes=Rake::all();
			return  response(['data' => $rakes,'status' => 200,]);  
		}

		catch(Exception $error){
			$title = $error->getMessage();
			$errors[]=['title' => $title];
			return response(["errors" => $errors,
				"status" => 500]);
		}       
	}
}
