<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kintai_details', function (Blueprint $table) {
            $table->bigIncrements('kintai_detail_id');
            $table->unsignedBigInteger('kintai_id');
            $table->unsignedBigInteger('customer_id');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->time('start_time_adj')->nullable();
            $table->time('end_time_adj')->nullable();
            $table->unsignedInteger('operating_time')->nullable();
            $table->timestamps();
            // 外部キー制約
            $table->foreign('kintai_id')->references('kintai_id')->on('kintais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kintai_details');
    }
};
