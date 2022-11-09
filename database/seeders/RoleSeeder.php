<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_id' => 1,
            'role_name' => 'システム管理者',
        ]);
        Role::create([
            'role_id' => 11,
            'role_name' => '経理',
        ]);
        Role::create([
            'role_id' => 21,
            'role_name' => '本社',
        ]);
        Role::create([
            'role_id' => 31,
            'role_name' => '拠点管理者',
        ]);
        Role::create([
            'role_id' => 41,
            'role_name' => '打刻用',
        ]);
    }
}
