<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    protected $table      = 'permissions';
    protected $primaryKey = 'permission_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table)
        {
           $table->increments($this->primaryKey);
           $table->string('permission_title');
           $table->string('permission_slug');
           $table->string('permission_description')->nullable();
           $table->boolean('permission_exception');
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
