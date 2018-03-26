<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryPictureTable extends Migration
{
    protected $table = 'gallery_picture';
    protected $primaryKey = 'id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( $this->table, function (Blueprint $newtable) {
        	
           $newtable->increments('id');
	       $newtable->integer('gallery_id');
	       $newtable->integer('picture_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gallery_picture');
    }
}
