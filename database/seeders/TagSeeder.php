<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            'owner_role_id' => 11,
            'tag_name' => '要確認',
        ]);
        Tag::create([
            'owner_role_id' => 11,
            'tag_name' => '要修正',
        ]);
        Tag::create([
            'owner_role_id' => 11,
            'tag_name' => '確認済',
        ]);
        Tag::create([
            'owner_role_id' => 31,
            'tag_name' => '確認済',
        ]);
    }
}
