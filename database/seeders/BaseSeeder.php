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
            'base_id' => 1,
            'base_name' => '本社',
        ]);
        Base::create([
            'base_id' => 2,
            'base_name' => '第1営業所',
        ]);
        Base::create([
            'base_id' => 3,
            'base_name' => '第2営業所',
        ]);
        Base::create([
            'base_id' => 4,
            'base_name' => '第3営業所',
        ]);
        Base::create([
            'base_id' => 5,
            'base_name' => '第4営業所',
        ]);
        Base::create([
            'base_id' => 6,
            'base_name' => 'ロジステーション',
        ]);
        Base::create([
            'base_id' => 7,
            'base_name' => 'ロジポート',
        ]);
        Base::create([
            'base_id' => 8,
            'base_name' => '広島営業所',
        ]);
        Base::create([
            'base_id' => 9,
            'base_name' => 'ロジコンタクト',
        ]);
        Base::create([
            'base_id' => 10,
            'base_name' => '倉庫管理課',
        ]);
        Base::create([
            'base_id' => 11,
            'base_name' => 'システム係',
        ]);
    }
}
