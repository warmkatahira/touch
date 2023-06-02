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
            'user_id' => '01',
            'user_name' => '本社',
            'email' => 't.katahira@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 31,
            'base_id' => 'warm_02',
            'status' => 1,
        ]);
    }
}
