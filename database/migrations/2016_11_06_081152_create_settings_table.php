<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    protected $table      = 'settings';
    protected $primaryKey = 'setting_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( $this->table, function (Blueprint $newtable) {
        	
            $newtable->increments($this->primaryKey);
            $newtable->string('setting_site_title',225);
            $newtable->string('setting_site_slogan',225);
            $newtable->boolean('setting_multi_lang');
            $newtable->string('setting_timeformat',1);
            $newtable->boolean('setting_membership');
	    $newtable->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
