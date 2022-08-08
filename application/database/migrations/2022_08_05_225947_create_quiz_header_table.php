<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_header', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quiz_code', 32)->nullable();
            $table->string('email', 255)->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time');
            $table->dateTime('timeout')->nullable();
            $table->smallInteger('total_score')->nullable();
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
        Schema::dropIfExists('quiz_header');
    }
}
