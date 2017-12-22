<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coach_id')->unsigned()->unique();
            $table->date('shell_rec')->nullable();
            $table->date('intake')->nullable();
            $table->text('agency')->nullable();
            $table->date('conduit')->nullable();
            $table->date('coupler')->nullable();
            $table->date('ew_panel')->nullable();
            $table->date('roof_tray')->nullable();
            $table->date('ht_tray')->nullable();
            $table->date('ht_equip')->nullable();
            $table->date('high_dip')->nullable();
            $table->date('uf_tray')->nullable();
            $table->date('uf_trans')->nullable();
            $table->text('uf_wire')->nullable();
            $table->date('off_roof')->nullable();
            $table->date('roof_clear')->nullable();
            $table->date('off_ew')->nullable();
            $table->date('ew_clear')->nullable();
            $table->text('mech_pan')->nullable();
            $table->date('off_tf')->nullable();
            $table->date('tf_clear')->nullable();
            $table->date('tf_prov')->nullable();
            $table->date('lf_load')->nullable();
            $table->date('off_pow')->nullable();
            $table->date('power_hv')->nullable();
            $table->date('off_dip')->nullable();
            $table->date('dip_clear')->nullable();
            $table->date('lower')->nullable();
            $table->date('off_cont')->nullable();
            $table->date('cont_hv')->nullable();
            $table->date('load_test')->nullable();
            $table->date('rmvu')->nullable();
            $table->date('panto')->nullable();
            $table->date('pcp_clear')->nullable();
            $table->date('bu_form')->nullable();
            $table->date('rake_form')->nullable();
            $table->text('remarks')->nullable();
            $table->foreign('coach_id')->references('id')->on('coaches');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coach_statuses');
    }
}
