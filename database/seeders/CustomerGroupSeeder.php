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
            'base_id' => 'warm_02',
            'customer_group_name' => 'A棟',
            'customer_group_order' => 1,
        ]);
        CustomerGroup::create([
            'base_id' => 'warm_02',
            'customer_group_name' => 'コンタクト',
            'customer_group_order' => 2,
        ]);
        CustomerGroup::create([
            'base_id' => 'warm_02',
            'customer_group_name' => 'DDD',
            'customer_group_order' => 3,
        ]);
    }
}
