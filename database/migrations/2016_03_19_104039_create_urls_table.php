<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('urls', function (Blueprint $table) {
            
            $table->increments('url_id');
            $table->string('url_slug',15);
            $table->string('url_title',15);
            $table->string('url_namespace',15);
            $table->string('url_controller',15);
            $table->string('url_icon_class');
	    $table->string('url_type');              
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
        Schema::drop('urls');
    }
}
