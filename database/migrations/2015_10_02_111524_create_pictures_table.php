<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    protected $table      = 'pictures';
    protected $primaryKey = 'picture_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $newtable) {  
            $newtable->increments($this->primaryKey);
	    $newtable->integer('user_id');
	    $newtable->integer('food_id');
	    $newtable->string('picture_owner',15);
            $newtable->string('picture_title',50);
	    $newtable->string('picture_slug',50);
	    $newtable->string('picture_ext',15);
	    $newtable->string('picture_type', 15 );
            $newtable->string('picture_status', 15 );
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
