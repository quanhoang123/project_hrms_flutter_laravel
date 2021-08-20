<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDangKyUngTuyenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dang_ky_ung_tuyen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nameEmp');
            $table->string('gender');
            $table->string('dienthoai')->nullable();
            $table->string('email')->nullable();
            $table->string('file_cv')->nullable();
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->string('status')->default(true);
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
        Schema::dropIfExists('dang_ky_ung_tuyen');
    }
}
