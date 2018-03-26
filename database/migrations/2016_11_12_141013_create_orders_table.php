<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    protected $table      = 'orders';
    protected $primaryKey = 'order_id';
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
            $table->boolean('order_is_paid');
            $table->string('order_delivery_type');
            $table->string('order_status',25);
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
