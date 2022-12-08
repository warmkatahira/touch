<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Base;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Base::create([
            'base_id' => 'system_common',
            'base_name' => 'システム共通',
        ]);
        Base::create([
            'base_id' => 'warm_01',
            'base_name' => '本社',
        ]);
        Base::create([
            'base_id' => 'warm_02',
            'base_name' => '第1営業所',
        ]);
        Base::create([
            'base_id' => 'warm_03',
            'base_name' => '第2営業所',
        ]);
        Base::create([
            'base_id' => 'warm_04',
            'base_name' => '第3営業所',
        ]);
        Base::create([
            'base_id' => 'warm_05',
            'base_name' => '第4営業所',
        ]);
        Base::create([
            'base_id' => 'warm_06',
            'base_name' => 'ロジステーション',
        ]);
        Base::create([
            'base_id' => 'warm_07',
            'base_name' => 'ロジポート',
        ]);
        Base::create([
            'base_id' => 'warm_08',
            'base_name' => '広島営業所',
        ]);
        Base::create([
            'base_id' => 'warm_09',
            'base_name' => 'ロジコンタクト',
        ]);
        Base::create([
            'base_id' => 'warm_10',
            'base_name' => '倉庫管理課',
        ]);
        Base::create([
            'base_id' => 'warm_11',
            'base_name' => 'システム係',
        ]);
        Base::create([
            'base_id' => 'warm_12',
            'base_name' => 'ロジステーションプラス',
        ]);
    }
}
