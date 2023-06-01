<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LectureCategory;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Http\Requests\LectureRequest;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function index(
        Request $request,
        Lecture $lecture,
        LectureCategory $lecture_category,
        Faculty $faculty,
        Department $department,
        Course $course
    ){
        $lectures = $lecture;
        
        //絞り込み検索処理
        
        //キーワード検索
        $search_word = $request->input('search_word'); 
        if( !(empty($search_word)) ){
            $lectures = $lectures->where('name', 'LIKE', '%'.$search_word.'%');
        } 
        
        //講義カテゴリー検索
        $search_category = $request->input('search_category');
        if( !(empty($search_category)) ){
            $lectures = $lectures->where('lecture_category_id', $search_category);
        }    
        
        //学部検索
        $search_faculty = $request->input('search_faculty');
        if( !(empty($search_faculty)) ){
            $lectures = $lectures->where('faculty_id', $search_faculty);
        }
        
        //学科検索
        $search_department = $request->input('search_department');
        if( !(empty($search_department)) ){
            $lectures = $lectures->where('department_id', $search_department);
        }
        
        //コース検索
        $search_course = $request->input('search_course');
        if( !(empty($search_course)) ){
            $lectures = $lectures->where('course_id', $search_course);
        }
        
        $lectures = $lectures->withcount('reviews')->get();
        $result_count = $lectures->count();
        
        return view('lectures/index')->with([
            'lectures' => $lectures,
            'lecture_categories' => $lecture_category->get(),
            'faculties' => $faculty->get(),
            'departments' => $department->get(),
            'courses' => $course->get(),
            'result_count' => $result_count
        ]);

    }

    public function create(
        LectureCategory $lecture_category,
        Faculty $faculty,
        Department $department,
        Course $course
    ){
        return view('lectures/create')->with([
            'lecture_categories' => $lecture_category->get(),
            'faculties' => $faculty->get(),
            'departments' => $department->get(),
            'courses' => $course->get()
        ]);
    }

    public function store(LectureRequest $request, Lecture $lecture){
        $lecture_input = $request['lecture'];
        $lecture_input['user_id'] = Auth::id();
        $lecture->fill($lecture_input)->save();
        return redirect()->route('lecture.index');
    }

    public function show(Lecture $lecture)
    {
        return view('lectures/show')->with(['lecture' => $lecture]);
    }

    public function edit(
        Lecture $lecture,
        LectureCategory $lecture_category,
        Faculty $faculty,
        Department $department,
        Course $course
    ){
        return view('lectures/edit')->with([
            'lecture' => $lecture,
            'lecture_categories' => $lecture_category->get(),
            'faculties' => $faculty->get(),
            'departments' => $department->get(),
            'courses' => $course->get()
        ]);
    }

    public function update(LectureRequest $request, Lecture $lecture)
    {
        //編集は誰でも可能だが投稿者は上書きしない
        $lecture_input = $request['lecture'];
        $lecture->fill($lecture_input)->save();
        return redirect()->route('lecture.show', ['lecture' => $lecture->id]);
    }

    public function destroy(Lecture $lecture)
    {
        $lecture->delete();
        return redirect()->route('lecture.index');
    }
}
