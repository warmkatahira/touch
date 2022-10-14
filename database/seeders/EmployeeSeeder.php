<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'employee_no' => '0001',
            'base_id' => 1,
            'employee_name' => '社員A',
            'employee_category_id' => 1,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '0002',
            'base_id' => 1,
            'employee_name' => '社員B',
            'employee_category_id' => 1,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '0003',
            'base_id' => 1,
            'employee_name' => '社員C',
            'employee_category_id' => 1,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '1001',
            'base_id' => 1,
            'employee_name' => 'パートA',
            'employee_category_id' => 2,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '0005',
            'base_id' => 1,
            'employee_name' => '社員D',
            'employee_category_id' => 1,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '1002',
            'base_id' => 1,
            'employee_name' => 'パートB',
            'employee_category_id' => 2,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '1003',
            'base_id' => 1,
            'employee_name' => 'パートC',
            'employee_category_id' => 2,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '1004',
            'base_id' => 1,
            'employee_name' => 'パートD',
            'employee_category_id' => 2,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '1005',
            'base_id' => 1,
            'employee_name' => 'パートE',
            'employee_category_id' => 2,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '1006',
            'base_id' => 1,
            'employee_name' => 'パートF',
            'employee_category_id' => 2,
            'hourly_wage' => 2000,
        ]);
    }
}
