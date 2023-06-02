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
            $table->string('kintai_detail_id')->primary();
            $table->string('kintai_id');
            $table->string('customer_id');
            $table->unsignedInteger('customer_working_time');
            $table->boolean('is_supported');
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
