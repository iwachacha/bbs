<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecture;
use App\Models\LectureCategory;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\LectureRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LectureController extends Controller
{
    public function index()
    {
        return Inertia::render('Lecture/Index');
    }
    
    public function create()
    {
        $lecture_categories = LectureCategory::all();
        $faculties = Faculty::all();
        $departments = Department::all();
        $courses = Course::all();
        
        return Inertia::render('Lecture/Create')->with([
            'lectureCategories' => $lecture_categories,
            'faculties' => $faculties,
            'departments' => $departments,
            'courses' => $courses
        ]);
    }

    public function store(LectureRequest $request)
    {
        $input = $request->validated();
        Lecture::create($input);
    }
    
    /*public function index(Request $request, Lecture $lecture){
        
        list($result_count, $lectures) = $lecture->search_lectures($request); // /Models/Lecture.phpに定義した検索処理
        
        $request->session()->flash('message', $result_count.'件取得しました');
        
        return view('lectures/index')->with(['lectures' => $lectures, 'result_count' => $result_count]);
        
    }

    public function create(){
        
        return view('lectures/create'); // ビューで使用する変数は /Composers/LectureComposerに定義
        
    }

    public function store(LectureRequest $request, Lecture $lecture){
        
        $lecture_input = $request['lecture'];
        $lecture_input['user_id'] = Auth::id();
        $lecture->fill($lecture_input)->save();
        return redirect()->route('lecture.index');
        
    }

    public function show(Lecture $lecture){
        
        return view('lectures/show')->with(['lecture' => $lecture]);
        
    }
    
    public function edit(Lecture $lecture){
        
        return view('lectures/edit')->with(['lecture' => $lecture]); // ビューで使用する変数は /Composers/LectureComposerに定義
        
    }

    public function update(LectureRequest $request, Lecture $lecture){
        
        $lecture_input = $request['lecture']; //name = "lecture['hoge']"の形で送られる
        $lecture_input['user_id'] = Auth::id();
        $lecture->fill($lecture_input)->save();
        return redirect()->route('lecture.show', ['lecture' => $lecture->id]);
        
    }

    /*public function destroy(Lecture $lecture){
        
        $lecture->delete();
        return redirect()->route('lecture.index');
        
    }*/
}
