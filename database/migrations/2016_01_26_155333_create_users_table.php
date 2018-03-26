<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    protected $table      = 'users';
    protected $primaryKey = 'user_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table)
        {
            $table->increments($this->primaryKey)->unsigned();
            $table->integer('role_id');
            $table->string('user_email')->unique();
            $table->string('user_password');
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->string('user_status',25);
            $table->rememberToken();
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
        Schema::drop($this->table);
    }
}
