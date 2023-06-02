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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('customer_id')->primary();
            $table->string('customer_name');
            $table->unsignedInteger('customer_group_id')->nullable();
            $table->string('control_base_id');
            $table->timestamps();
            // 外部キー(削除されたらnullになるようにしてある)
            $table->foreign('customer_group_id')->references('customer_group_id')->on('customer_groups')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
