<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerGroup;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerGroup::create([
            'base_id' => 'system_common',
            'customer_group_name' => '応援',
            'customer_group_order' => 1,
        ]);
        CustomerGroup::create([
            'base_id' => 'warm_01',
            'customer_group_name' => 'A棟',
            'customer_group_order' => 1,
        ]);
        CustomerGroup::create([
            'base_id' => 'warm_01',
            'customer_group_name' => 'コンタクト',
            'customer_group_order' => 2,
        ]);
    }
}
