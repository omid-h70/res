<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidebarUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sidebar_url', function(Blueprint $table)
      {
         $table->increments('id');
         $table->integer('sidebar_id');
         $table->integer('url_id');
         $table->integer('url_depth_level');
         $table->integer('url_parent_id');
         $table->integer('url_order');
         
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sidebar_url');
    }
}
