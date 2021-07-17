<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterm1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interm1s', function (Blueprint $table) {
            $table->integer('ord_id');
            $table->integer('boo_id');

            $table->foreign('ord_id')->references('order_id')->on('orders');

            $table->foreign('boo_id')->references('id')->on('books');

            $table->decimal('quantity',10,4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interm1s');
    }
}
