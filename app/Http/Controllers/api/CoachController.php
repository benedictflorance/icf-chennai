<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Coach;
use App\Rake;
use App\User;
use App\CoachStatus;
use App\Position;
use Validator;

class CoachController extends Controller
{
    //
	public function store(Request $request)
	{
		try{
			$validator = Validator::make($request->all(),[
				'coach_num' => 'required|max:15|unique:coaches,coach_num',
				'rake_num' => 'required|max:15',
				'type' => 'required|max:15'
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
					$rake = Rake::where('rake_num',$request->input('rake_num'))->first();
					if($rake)
					{
						$coach = Coach::create([
							'rake_id' => $rake->id,
							'coach_num' => $request->input('coach_num'),
							'type' => $request->input('type') 
						]);
						$message=$coach->coach_num." has been added";
						$data=['message' => $message];
						$status=200;
						return response(["data" => $data, "status" => $status]);
					}
					else
					{
						$errors[]=[
							'title' => 'Rake does not exist',
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
						'title' => 'Unauthorized to add new coaches',
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
			$coaches=Coach::all();
			foreach($coaches as $coach)
				$coach->rake_num = Rake::where('id',$coach->rake_id)->first()->rake_num;
			return  response(['data' => $coaches,'status' => 200,]);  
		}

		catch(Exception $error){
			$title = $error->getMessage();
			$errors[]=['title' => $title];
			return response(["errors" => $errors,
				"status" => 500]);
		}       
	}

	public function getByNumber($coach_num)
	{
		try
		{ 
			$coach=Coach::where('coach_num',$coach_num)->first();
			if($coach)
			{
				$coach->rake_num = Rake::where('id',$coach->rake_id)->first()->rake_num;
				return  response(['data' => $coach,'status' => 200,]);
			}
			else{
				$errors[]=[
					'title' => 'Coach does not exist',
				];
				return  response([
					'errors' => $errors,
					'status' => 400,
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
	public function getStatus($coach_num)
	{
		try
		{ 
			$coach=Coach::where('coach_num',$coach_num)->first();
			if($coach)
			{
				$coach_id = $coach->id;
				$status = CoachStatus::where('coach_id',$coach_id)->first();
				if($status)
				{
					$status->coach_num = $coach->coach_num;
					$status->rake_num = Rake::where('id',$coach->rake_id)->first()->rake_num;
					return  response(['data' => $status,'status' => 200,]);
				}
				else{
				$errors[]=[
					'title' => 'Status does not exist for this coach',
				];
				return  response([
					'errors' => $errors,
					'status' => 400,
				]);
			}  
			}
			else{
				$errors[]=[
					'title' => 'Coach does not exist',
				];
				return  response([
					'errors' => $errors,
					'status' => 400,
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
	public function getPosition($coach_num)
	{
		try
		{ 
			$coach=Coach::where('coach_num',$coach_num)->first();
			if($coach)
			{
				$coach_id = $coach->id;
				$position = Position::where('coach_id',$coach_id)->first();
				if($position)
				{
					$position->coach_num = $coach->coach_num;
					$position->rake_num = Rake::where('id',$coach->rake_id)->first()->rake_num;
					return  response(['data' => $position,'status' => 200,]);
				}
				else{
				$errors[]=[
					'title' => 'Position does not exist for this coach',
				];
				return  response([
					'errors' => $errors,
					'status' => 400,
				]);
			}  
			}
			else{
				$errors[]=[
					'title' => 'Coach does not exist',
				];
				return  response([
					'errors' => $errors,
					'status' => 400,
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
