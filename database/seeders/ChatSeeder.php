<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    public function run()
    {
        DB::table('thread_categories')->insert([
            'name' => '雑談',
        ]);

        DB::table('thread_categories')->insert([
            'name' => 'お悩み相談'
        ]);

        DB::table('thread_categories')->insert([
            'name' => '講義'
        ]);

        DB::table('thread_categories')->insert([
            'name' => '課外活動'
        ]);

        DB::table('thread_categories')->insert([
            'name' => 'ゼミ'
        ]);

        DB::table('thread_categories')->insert([
            'name' => '実習'
        ]);

        DB::table('thread_categories')->insert([
            'name' => '就活'
        ]);

        DB::table('thread_categories')->insert([
            'name' => '資格'
        ]);

        DB::table('thread_categories')->insert([
            'name' => '恋愛'
        ]);

        DB::table('thread_categories')->insert([
            'name' => 'アルバイト'
        ]);

        DB::table('thread_categories')->insert([
            'name' => 'イベント'
        ]);

        DB::table('thread_categories')->insert([
            'name' => 'その他'
        ]);
    }
}
