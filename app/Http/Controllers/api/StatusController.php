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

class StatusController extends Controller
{
    //
	public function store(Request $request){
		try{
			$rules=[
				'coach_num' => 'required|max:15',
				'shell_rec' => 'date_format:Y-m-d',
				'intake' => 'date_format:Y-m-d',
				'agency' => 'string|max:65534',
				'conduit' => 'date_format:Y-m-d',
				'coupler' => 'date_format:Y-m-d',
				'ew_panel' => 'date_format:Y-m-d',
				'roof_tray' => 'date_format:Y-m-d',
				'ht_tray' => 'date_format:Y-m-d',
				'ht_equip' => 'date_format:Y-m-d',
				'high_dip' => 'date_format:Y-m-d',
				'uf_tray' => 'date_format:Y-m-d',
				'uf_trans' => 'date_format:Y-m-d',
				'uf_wire' => 'string|max:65534',
				'off_roof' => 'date_format:Y-m-d',
				'roof_clear' => 'date_format:Y-m-d',
				'off_ew' => 'date_format:Y-m-d',
				'ew_clear' => 'date_format:Y-m-d',
				'mech_pan' => 'string|max:65534',
				'off_tf' => 'date_format:Y-m-d',
				'tf_clear' => 'date_format:Y-m-d',
				'tf_prov' => 'date_format:Y-m-d',
				'lf_load' => 'date_format:Y-m-d',
				'off_pow' => 'date_format:Y-m-d',
				'power_hv' => 'date_format:Y-m-d',
				'off_dip' => 'date_format:Y-m-d',
				'dip_clear' => 'date_format:Y-m-d',
				'lower' => 'date_format:Y-m-d',
				'off_cont' => 'date_format:Y-m-d',
				'cont_hv' => 'date_format:Y-m-d',
				'load_test' => 'date_format:Y-m-d',
				'rmvu' => 'date_format:Y-m-d',
				'panto' => 'date_format:Y-m-d',
				'pcp_clear' => 'date_format:Y-m-d',
				'bu_form' => 'date_format:Y-m-d',
				'rake_form' => 'date_format:Y-m-d',
				'remarks'=> 'string|max:65534',

			];
			$fields=collect(['shell_rec','intake','agency','conduit','coupler','ew_panel','roof_tray','ht_tray','ht_equip','high_dip','uf_tray','uf_trans','uf_wire','off_roof','roof_clear','off_ew','ew_clear','mech_pan','off_tf','tf_clear','tf_prov','lf_load','off_pow','power_hv','off_dip','dip_clear','lower','off_cont','cont_hv','load_test','rmvu','panto','pcp_clear','bu_form','rake_form','remarks']);
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
						$status = CoachStatus::where('coach_id',$coach_id)->first();
						if($status)
						{
							$data = $request->only(['shell_rec','intake','agency','conduit','coupler','ew_panel','roof_tray','ht_tray','ht_equip','high_dip','uf_tray','uf_trans','uf_wire','off_roof','roof_clear','off_ew','ew_clear','mech_pan','off_tf','tf_clear','tf_prov','lf_load','off_pow','power_hv','off_dip','dip_clear','lower','off_cont','cont_hv','load_test','rmvu','panto','pcp_clear','bu_form','rake_form','remarks']);
							CoachStatus::where('coach_id',$coach_id)->first()->update($data);
							$message="Status has been updated successfully for ".$coach->coach_num;
						}
						else
						{
							$data = array_merge($request->only(['shell_rec','intake','agency','conduit','coupler','ew_panel','roof_tray','ht_tray','ht_equip','high_dip','uf_tray','uf_trans','uf_wire','off_roof','roof_clear','off_ew','ew_clear','mech_pan','off_tf','tf_clear','tf_prov','lf_load','off_pow','power_hv','off_dip','dip_clear','lower','off_cont','cont_hv','load_test','rmvu','panto','pcp_clear','bu_form','rake_form','remarks']), ['coach_id' => $coach_id]);
							CoachStatus::create($data);
							$message="Status has been added successfully for ".$coach->coach_num;

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
						'title' => 'Unauthorized to add new statuses',
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
			$statuses=CoachStatus::all();
			foreach($statuses as $status)
				$status->coach_num = Coach::where('id',$status->coach_id)->first()->coach_num;
			return  response(['data' => $statuses,'status' => 200,]);  
		}

		catch(Exception $error){
			$title = $error->getMessage();
			$errors[]=['title' => $title];
			return response(["errors" => $errors,
				"status" => 500]);
		}   
	}
}