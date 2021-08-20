<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal__courses', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->increments('id');
            $table->string('topic');
            $table->text('hosts');
            $table->string('amount_person');
            $table->string('location');
            $table->string('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('nhan_sus')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal__courses');
    }
}
