<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\LectureCategory;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;

class LectureComposer
{
    public function compose(View $view){
        
        $view->with([
            'lecture_categories' => LectureCategory::get(),
            'faculties' => Faculty::get(),
            'departments' => Department::get(),
            'courses' => Course::get(),
        ]);
  }
}