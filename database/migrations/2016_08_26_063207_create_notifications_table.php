<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( $this->table, function (Blueprint $newtable) {
        	
            $newtable->increments($this->primaryKey);
            $newtable->integer('notification_owner_id');
	    $newtable->string('notification_owner',15);
            $newtable->string('notification_slug',15);
            $newtable->string('notification_title',15);
            $newtable->string('notification_type',15);
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
