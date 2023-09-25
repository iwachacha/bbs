<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('tags')->insert([
            'name' => '神授業',
        ]);
        
        DB::table('tags')->insert([
            'name' => '楽単',
        ]);
    }
}
