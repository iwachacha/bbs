<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LectureCategory;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;
use App\Models\Lecture;
use App\Http\Requests\LectureRequest;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function index(Lecture $lecture)
    {
        $lectures = Lecture::withCount('reviews')->get();
        return view('lectures/index')->with(['lectures' => $lectures]);  
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
