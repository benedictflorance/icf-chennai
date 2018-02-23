<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Rake;
use App\User;
use App\Coach;
use App\CoachStatus;
use App\Position;

class RakeController extends Controller
{
    //
	public function store(Request $request)
	{
		try{
			$validator = Validator::make($request->all(),[
				'railway' => 'required|max:15',
				'rake_num' => 'required|max:15|unique:rakes,rake_num',
				'despatch' => 'date_format:Y-m-d'
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
						'rake_num' => $request->input('rake_num'),
						'despatch' => $request->input('despatch') 
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
	public function edit(Request $request)
	{
		try{
			$validator = Validator::make($request->all(),[
				'old_rakenum' => 'required|max:15',
				'railway' => 'required_without_all:rake_num,despatch|max:15',
				'rake_num' => 'required_without_all:railway,despatch|max:15|unique:rakes,rake_num',
				'despatch' => 'required_without_all:railway,rake_num|date_format:Y-m-d'
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
					$rake=Rake::where('rake_num',$request->input('old_rakenum'))->first();
					if($rake)
						{
							$rake->update($request->only(['railway', 'rake_num', 'despatch']));
							$message="Rake details have been updated";
							$data=['message' => $message];
							$status=200;
							return response(["data" => $data, "status" => $status]);
						}
					else{
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
	public function delete($rake_num, Request $request)
	{
		try
		{ 
			$user=User::where('token','=',$request->input('token'))->first();
			if($user->role == 'write' || $user->role == 'admin')
			{
				$rake_num=str_replace('_','/',$rake_num);
				$rake=Rake::where('rake_num',$rake_num)->first();
				if($rake)
				{
					$coaches = $rake->coaches;
					foreach($coaches as $coach)
					{
						if($coach->status)
							$coach->status->delete();
						if($coach->position)
							$coach->position->delete();
						$coach->delete();
					}
					$rake->delete();
					$message=$rake_num." has been deleted";
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
					'title' => 'Unauthorized to delete rakes',
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
	public function getDespatched(Request $request)
	{
		try
		{ 
			$rakes = Rake::whereNotNull('despatch')->get();
			return  response(['data' => $rakes,'status' => 200]);  
		}

		catch(Exception $error){
			$title = $error->getMessage();
			$errors[]=['title' => $title];
			return response(["errors" => $errors,
				"status" => 500]);
		}       
	}
	public function getByNumber($rake_num)
	{
		try
		{ 
			$rake_num=str_replace('_','/',$rake_num);
			$rake=Rake::where('rake_num',$rake_num)->first();
			if($rake)
				return  response(['data' => $rake,'status' => 200,]);
			else{
				$errors[]=[
					'title' => 'Rake does not exist',
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

	public function getAllCoaches($rake_num)
	{
		try
		{ 
			$rake_num=str_replace('_','/',$rake_num);
			$rake=Rake::where('rake_num',$rake_num)->first();
			if($rake)
				return  response(['data' => $rake->coaches,'status' => 200,]);
			else{
				$errors[]=[
					'title' => 'Rake does not exist',
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

	public function getAllStatuses($rake_num)
	{
		try
		{ 
			$rake_num=str_replace('_','/',$rake_num);
			$rake=Rake::where('rake_num',$rake_num)->first();
			if($rake)
				return  response(['data' => $rake->coaches->map(function($coach){
					if(isset($coach->status))
					{
						$coach->status->coach_num = $coach->coach_num;
						return $coach->status;
					}
				}),'status' => 200,]);
			else{
				$errors[]=[
					'title' => 'Rake does not exist',
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
	public function getAllPositions($rake_num)
	{
		try
		{ 
			$rake_num=str_replace('_','/',$rake_num);
			$rake=Rake::where('rake_num',$rake_num)->first();
			if($rake)
				return  response(['data' => $rake->coaches->map(function($coach){
					if(isset($coach->position))
					{
						$coach->position->coach_num = $coach->coach_num;
						return $coach->position;
					}
				}),'status' => 200,]);
			else{
				$errors[]=[
					'title' => 'Rake does not exist',
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
