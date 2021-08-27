<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhanSusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhan_sus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ho_ten');
            $table->boolean('gioi_tinh')->default(true);
            $table->datetime('ngay_sinh');
            $table->string('so_cmnd')->unique();
            $table->string('dia_chi_lien_he')->nullable();
            $table->string('dien_thoai')->nullable();
            $table->string('email')->nullable();
            $table->string('trinh_do')->nullable();
            $table->string('nam_tot_nghiep')->nullable();
            $table->datetime('ngay_bat_dau_lam')->nullable()->default(null);
            $table->datetime('ngay_lam_viec_cuoi')->nullable()->default(null);
            $table->string('chuc_danh')->nullable();
            $table->integer('phongban_id')->default(0);
            $table->integer('bophan_id')->default(0);
            $table->text('hoso_id')->nullable();
            $table->boolean('trang_thai')->default(true);
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
        Schema::dropIfExists('nhan_sus');
    }
}
