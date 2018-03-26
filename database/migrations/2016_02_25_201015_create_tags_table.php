<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tags', function(Blueprint $table)
        {
            $table->increments('tag_id')->unsigned();
            $table->integer('user_id');
            $table->string('tag_title');
            $table->string('tag_slug');
            $table->string('tag_type');
            $table->string('tag_status');
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
         Schema::drop('tags');
    }
}
