<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'syomomo0904@gmail.com',
            'password' => Hash::make('mamoru0518'),
            'faculty_id' => 1,
            'department_id' => 1,
            'course_id' => 1,
            'grade' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
    }
}
