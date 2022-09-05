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
            'employee_name' => '武　豊',
            'employee_category_id' => 1,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '0002',
            'base_id' => 1,
            'employee_name' => '川田　将雅',
            'employee_category_id' => 1,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '0003',
            'base_id' => 1,
            'employee_name' => '福永　祐一',
            'employee_category_id' => 1,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '0004',
            'base_id' => 1,
            'employee_name' => '松山　弘平',
            'employee_category_id' => 2,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '0005',
            'base_id' => 1,
            'employee_name' => 'C.ルメール',
            'employee_category_id' => 1,
            'hourly_wage' => 2000,
        ]);
        Employee::create([
            'employee_no' => '0006',
            'base_id' => 1,
            'employee_name' => '横山　武史',
            'employee_category_id' => 2,
            'hourly_wage' => 2000,
        ]);
    }
}
