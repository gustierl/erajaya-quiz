<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question_code', 255)->nullable();
            $table->text('question_name')->nullable();
            $table->text('option_one')->nullable();
            $table->text('option_two')->nullable();
            $table->text('option_three')->nullable();
            $table->string('answer', 255)->nullable();
            $table->smallInteger('score')->nullable();
            $table->string('status', 255)->nullable();
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
        Schema::dropIfExists('question');
    }
}
