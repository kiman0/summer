<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelp2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help2s', function (Blueprint $table) {
            $table->foreignId('sessions_id')->nullable()->unsigned();
            $table->foreign('sessions_id')->references('user_id')->on('sessions');

            $table->integer('bookss_id')->nullable();
            $table->foreign('bookss_id')->references('id')->on('books');

            $table->integer('bookss_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('help2s');
    }
}
