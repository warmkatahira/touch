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
        Schema::create('kintais', function (Blueprint $table) {
            $table->string('kintai_id')->primary();
            $table->string('employee_no');
            $table->date('work_day');
            $table->time('begin_time');
            $table->time('finish_time')->nullable();
            $table->time('begin_time_adj')->nullable();
            $table->time('finish_time_adj')->nullable();
            $table->time('out_time')->nullable();
            $table->time('return_time')->nullable();
            $table->time('out_time_adj')->nullable();
            $table->time('return_time_adj')->nullable();
            $table->boolean('out_enabled')->nullable();
            $table->unsignedInteger('rest_time')->nullable();
            $table->string('comment')->nullable();
            $table->unsignedInteger('out_return_time');
            $table->unsignedInteger('working_time')->nullable();
            $table->unsignedInteger('over_time')->nullable();
            $table->boolean('early_work_enabled');
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
        Schema::dropIfExists('kintais');
    }
};
