<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeCategory;

class EmployeeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeCategory::create([
            'employee_category_id' => 1,
            'employee_category_name' => '正社員',
        ]);
        EmployeeCategory::create([
            'employee_category_id' => 2,
            'employee_category_name' => 'パート',
        ]);
    }
}
