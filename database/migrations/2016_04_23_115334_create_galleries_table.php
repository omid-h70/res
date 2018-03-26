<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    protected $table = 'galleries';
    protected $primaryKey = 'gallery_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create( $this->table, function (Blueprint $newtable) {
        	
            $newtable->increments('gallery_id');
	        $newtable->integer('user_id');
            $newtable->string('article_slug');
            $newtable->string('article_title');     
            $newtable->string('gallery_status');
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
        Schema::drop('galleries');
    }
}
