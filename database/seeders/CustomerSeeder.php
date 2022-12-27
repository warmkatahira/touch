<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'customer_id' => 'warm_01',
            'customer_name' => '本社',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_02',
            'customer_name' => '第1営業所',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_03',
            'customer_name' => '第2営業所',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_04',
            'customer_name' => '第3営業所',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_05',
            'customer_name' => '第4営業所',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_06',
            'customer_name' => 'ロジステーション',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_07',
            'customer_name' => 'ロジポート',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_08',
            'customer_name' => '広島営業所',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_09',
            'customer_name' => 'ロジコンタクト',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_10',
            'customer_name' => '倉庫管理課',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_11',
            'customer_name' => 'システム係',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => 'warm_12',
            'customer_name' => 'ロジステーションプラス',
            'control_base_id' => 'system_common',
        ]);
        Customer::create([
            'customer_id' => '1',
            'customer_name' => '株式会社テスト',
            'control_base_id' => 'warm_02',
            'customer_group_id' => 2,
        ]);
        Customer::create([
            'customer_id' => '2',
            'customer_name' => '株式会社intervia',
            'control_base_id' => 'warm_02',
            'customer_group_id' => 3,
        ]);
        Customer::create([
            'customer_id' => '3',
            'customer_name' => '株式会社徳昇商事',
            'control_base_id' => 'warm_03',
        ]);
        Customer::create([
            'customer_id' => '4',
            'customer_name' => 'フロムアイズ株式会社',
            'control_base_id' => 'warm_02',
            'customer_group_id' => 3,
        ]);
        Customer::create([
            'customer_id' => '5',
            'customer_name' => '株式会社タピオカ',
            'control_base_id' => 'warm_02',
        ]);
        Customer::create([
            'customer_id' => '10',
            'customer_name' => '大洋製薬',
            'control_base_id' => 'warm_02',
        ]);
    }
}
