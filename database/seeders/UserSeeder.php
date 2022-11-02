<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '本社',
            'user_name' => '01',
            'email' => 'warm01@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 41,
            'base_id' => 1,
            'status' => 1,
        ]);
    }
}
