<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleSidebarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('role_sidebar', function(Blueprint $table)
      {
         $table->increments('id');
         $table->integer('role_id');
         $table->integer('sidebar_id');
         
         
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_sidebar');
    }
}
