<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Http\Requests\LectureRequest;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function index(Request $request, Lecture $lecture){
        
        $lectures = $lecture;
        $lectures = $lectures->search_lectures($request); // /Models/Lecture.phpに定義した検索処理
        $result_count = $lectures->count(); //講義の取得件数

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
