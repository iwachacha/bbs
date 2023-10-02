<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ReportController extends Controller
{
    //重複なしで報告を保存
    public function report(Request $request)
    {
        if($request->has('reportee_id')){
            if(!Report::where('reporter_id', Auth::id())->where('reportee_id', $request->reportee_id)->exists()){
                Report::create([
                    'reporter_id' => Auth::id(),
                    'reportee_id' => $request->reportee_id
                ]);
            }
        }

        if($request->has('lecture_id')){
            if(!Report::where('reporter_id', Auth::id())->where('lecture_id', $request->lecture_id)->exists()){
                Report::create([
                    'reporter_id' => Auth::id(),
                    'lecture_id' => $request->lecture_id
                ]);
            }
        }

        if($request->has('review_id')){
            if(!Report::where('review_id', Auth::id())->where('review_id', $request->review_id)->exists()){
                Report::create([
                    'reporter_id' => Auth::id(),
                    'review_id' => $request->review_id
                ]);
            }
        }
    }
}
