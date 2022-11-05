<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            BaseSeeder::class,
            CustomerGroupSeeder::class,
            CustomerSeeder::class,
            UserSeeder::class,
            EmployeeCategorySeeder::class,
            EmployeeSeeder::class,
            TagSeeder::class,
        ]);
    }
}
