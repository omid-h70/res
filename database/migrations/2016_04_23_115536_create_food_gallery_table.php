<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodGalleryTable extends Migration
{
    protected $table = 'food_gallery';
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
	    $newtable->integer('food_id');
	    $newtable->integer('gallery_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( $this->table );
    }
}
