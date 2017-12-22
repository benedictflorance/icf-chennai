<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoachStatus extends Model
{
    //
	protected $fillable=['coach_id','shell_rec','intake','agency','conduit','coupler','ew_panel','roof_tray','ht_tray','ht_equip','high_dip','uf_tray','uf_trans','uf_wire','off_roof','roof_clear','off_ew','ew_clear','mech_pan','off_tf','tf_clear','tf_prov','lf_load','off_pow','power_hv','off_dip','dip_clear','lower','off_cont','cont_hv','load_test','rmvu','panto','pcp_clear','bu_form','rake_form','remarks'];
    protected $hidden=['created_at','updated_at'];
}
