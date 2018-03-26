<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('articles', function (Blueprint $newtable) {
        	
            $newtable->increments('article_id');
	    $newtable->integer('user_id');
            $newtable->string('article_slug');
            $newtable->string('article_title');
	    $newtable->string('article_body',10000);    
            $newtable->string('article_summary',255); 
            //$newtable->string('article_type',15); 
            //$newtable->string('file_name');
            $newtable->string('article_status');
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
        Schema::drop('articles');
    }
}
