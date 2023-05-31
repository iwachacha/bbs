<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;

class LectureSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('lecture_categories')->insert([
            'name' => '共通教養科目',
        ]);
        
        DB::table('lecture_categories')->insert([
            'name' => '外国語科目'
        ]);
        
        DB::table('lecture_categories')->insert([
            'name' => '体育科目'
        ]);
        
        DB::table('lecture_categories')->insert([
            'name' => '学部科目'
        ]);
        
        DB::table('lecture_categories')->insert([
            'name' => '専門科目'
        ]);
        
        DB::table('faculties')->insert([
            'name' => '教育学部'
        ]);
        
        DB::table('faculties')->insert([
            'name' => '人間科学部'
        ]);
        
        DB::table('faculties')->insert([
            'name' => '文学部'
        ]);
        
        DB::table('departments')->insert([
            'name' => '学校教育課程',
            'faculty_id' => 1
        ]);
        
        DB::table('departments')->insert([
            'name' => '発達教育課程',
            'faculty_id' => 1
        ]);
        
        DB::table('departments')->insert([
            'name' => '人間科学科',
            'faculty_id' => 2
        ]);
        
        DB::table('departments')->insert([
            'name' => '臨床心理学科',
            'faculty_id' => 2
        ]);
        
        DB::table('departments')->insert([
            'name' => '心理学科',
            'faculty_id' => 2
        ]);
        
        DB::table('departments')->insert([
            'name' => '日本語日本文学科',
            'faculty_id' => 3
        ]);
        
        DB::table('departments')->insert([
            'name' => '英米語英米文学科',
            'faculty_id' => 3
        ]);
        
        DB::table('departments')->insert([
            'name' => '中国語中国文学科',
            'faculty_id' => 3
        ]);
        
        DB::table('departments')->insert([
            'name' => '外国語学科',
            'faculty_id' => 3
        ]);
        
        DB::table('courses')->insert([
            'name' => '国語専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '社会専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '数学専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '理科専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '音楽専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '美術専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '体育専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '家庭専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '英語専修',
            'department_id' => 1
        ]);
        
        DB::table('courses')->insert([
            'name' => '特別支援教育専修',
            'department_id' => 2
        ]);
        
        DB::table('courses')->insert([
            'name' => '初等連携教育専修',
            'department_id' => 2
        ]);
        
        DB::table('courses')->insert([
            'name' => '児童心理教育専修',
            'department_id' => 2
        ]);
        
        DB::table('courses')->insert([
            'name' => '幼児心理教育専修',
            'department_id' => 2
        ]);
        
        DB::table('courses')->insert([
            'name' => '社会文化コース',
            'department_id' => 3
        ]);
        
        DB::table('courses')->insert([
            'name' => '人間教育コース',
            'department_id' => 3
        ]);
        
        DB::table('courses')->insert([
            'name' => '社会福祉コース',
            'department_id' => 3
        ]);
        
        DB::table('courses')->insert([
            'name' => 'スポーツ・コミュニティコース',
            'department_id' => 3
        ]);
        
        DB::table('courses')->insert([
            'name' => '心理学コース',
            'department_id' =>  5
        ]);
        
        DB::table('courses')->insert([
            'name' => '健康心理学コース',
            'department_id' =>  5
        ]);
        
        DB::table('courses')->insert([
            'name' => 'ビジネス心理学コース',
            'department_id' =>  5
        ]);
    }
}
