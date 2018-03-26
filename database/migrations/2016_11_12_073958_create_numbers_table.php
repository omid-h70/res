<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumbersTable extends Migration
{
    protected $table      = 'numbers';
    protected $primaryKey = 'number_id';
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
            $table->integer('user_id');
            $table->string('number_type');
            $table->integer('number_content');
            $table->string('number_status',25);
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
