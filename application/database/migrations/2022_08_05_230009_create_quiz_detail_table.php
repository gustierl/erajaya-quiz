<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quiz_code', 32)->nullable();
            $table->string('question_code', 255)->nullable();
            $table->string('answer', 255)->nullable();
            $table->smallInteger('score')->nullable();
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
        Schema::dropIfExists('quiz_detail');
    }
}
