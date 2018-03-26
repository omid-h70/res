<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidebarsTable extends Migration
{
     protected $table = 'sidebars' ;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create( $this->table , function (Blueprint $table) {
            
             $table->increments('sidebar_id');
             $table->integer('user_id');
             $table->string('sidebar_title',15);
             $table->string('sidebar_slug',15);
             $table->string('sidebar_type',15);
             $table->string('sidebar_status',15);
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
        Schema::drop( $this->table );
    }
}
