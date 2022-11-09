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
        Schema::create('kintai_tags', function (Blueprint $table) {
            $table->string('kintai_tag_id')->primary();
            $table->string('kintai_id');
            $table->unsignedBigInteger('register_user_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('kintai_id')->references('kintai_id')->on('kintais')->onDelete('cascade');
            $table->foreign('tag_id')->references('tag_id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kintai_tags');
    }
};
