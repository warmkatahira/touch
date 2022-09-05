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
        Schema::create('employees', function (Blueprint $table) {
            $table->string('employee_no')->primary();
            $table->unsignedInteger('base_id');
            $table->string('employee_name');
            $table->unsignedInteger('employee_category_id');
            $table->unsignedInteger('start_customer_id')->nullable();
            $table->unsignedInteger('hourly_wage');
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
        Schema::dropIfExists('employees');
    }
};
