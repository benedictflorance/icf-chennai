<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Rake;
use App\Coach;
use App\CoachStatus;
use App\Position;

class PositionController extends Controller
{
    //
	public function store(Request $request){
		try{
			$rules=[
				'coach_num' => 'required|max:15',
				'linename' => 'max:127',
				'lineno' => 'integer|digits_between:1,2',
				'stage' => 'numeric|digits_between:1,2'

			];
			$fields=collect(['linename','lineno','stage']);
			foreach ($fields as $field) {
				$rules[$field].= '|required_without_all:' . implode(',', $fields->whereNotIn(null, [$field])->toArray());
			}
			$validator = Validator::make($request->all(),$rules);
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
					$coach = Coach::where('coach_num',$request->input('coach_num'))->first();
					if($coach)
					{
						$coach_id=$coach->id;
						$status = Position::where('coach_id',$coach_id)->first();
						if($status)
						{
							$data = $request->only(['linename','lineno','stage']);
							Position::where('coach_id',$coach_id)->first()->update($data);
							$message="Position has been updated successfully for ".$coach->coach_num;
						}
						else
						{
							$data = array_merge($request->only(['linename','lineno','stage']), ['coach_id' => $coach_id]);
							Position::create($data);
							$message="Position has been added successfully for ".$coach->coach_num;

						}
						$data=['message' => $message];
						$status=200;
						return response(["data" => $data, "status" => $status]);
					}
					else
					{
						$errors[]=[
							'title' => 'Coach does not exist',
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
						'title' => 'Unauthorized to add new positions',
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
	public function getall()
	{
		try
		{ 
			$positions=Position::all();
			foreach($positions as $position)
			{
				$coach = Coach::where('id',$position->coach_id)->first();
				$position->coach_num = $coach->coach_num;
				$position->rake_num = Rake::where('id',$coach->rake_id)->first()->rake_num;
			}
			    return  response(['data' => $positions,'status' => 200,]); 
		}

		catch(Exception $error){
			$title = $error->getMessage();
			$errors[]=['title' => $title];
			return response(["errors" => $errors,
				"status" => 500]);
		}   
	}
}
