<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table)
        {
            $table->increments('category_id')->unsigned();
            $table->integer('user_id');
            $table->string('category_title');
            $table->string('category_slug');
            $table->string('category_type');
            $table->string('category_status');
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
         Schema::drop('categories');
    }
    /**
     * 
     * 
     */

}
