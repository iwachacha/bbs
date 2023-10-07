<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        //重複なしで報告を保存
        if($request->has('lecture_id')){
            if(!Report::where('user_id', Auth::id())->where('lecture_id', $request->lecture_id)->exists()){
                Report::create([
                    'user_id' => Auth::id(),
                    'lecture_id' => $request->lecture_id
                ]);
            }
        }

        if($request->has('review_id')){
            if(!Report::where('user_id', Auth::id())->where('review_id', $request->review_id)->exists()){
                Report::create([
                    'user_id' => Auth::id(),
                    'review_id' => $request->review_id
                ]);
            }
        }

        if($request->has('thread_id')){
            if(!Report::where('user_id', Auth::id())->where('thread_id', $request->thread_id)->exists()){
                Report::create([
                    'user_id' => Auth::id(),
                    'thread_id' => $request->thread_id
                ]);
            }
        }
    }
}
