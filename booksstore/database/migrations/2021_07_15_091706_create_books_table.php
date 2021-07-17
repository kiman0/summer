<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->integer('id')->unique();;
            $table->primary('id');;

            $table->string('book_name');
            $table->string('book_author');
            $table->decimal('book_price',10,4);
            $table->string('category');
            $table->foreign('category')->references('category_name')->on('categories');
            $table->longText('description')->nullable();
            $table->string('data_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
