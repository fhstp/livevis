<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');

            //Create Category Id
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');

            // Create Text column
            $table->string('question');

            // Create string column with max. 50 characters
            $table->string('type', 50)->default('Multiple Choice');

            // Create string column with max. 50 characters
            $table->string('keyword', 50);

            $table->boolean('active')->default(0);

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
        Schema::dropIfExists('questions');
    }
}
