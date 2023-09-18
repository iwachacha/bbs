<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Lecture;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function index($lecture_id)
    {
        $lecture = Lecture::with('reviews')
          ->withCount('reviews')
          ->withAvg('reviews as average_rate', 'average_rate')
          ->find($lecture_id);

        return Inertia::render('Review/Index')->with([
          'lecture' => $lecture
        ]);
    }

    public function create(Lecture $lecture)
    {
        return Inertia::render('Review/Create')->with(['lecture' => $lecture]);
    }

    public function store(Lecture $lecture, ReviewRequest $request, Review $review)
    {
        $input = $request->validated();
        $input['lecture_id'] = $lecture->id;
        $input['user_id'] = Auth::id();
        $input['average_rate'] = $review->getAverageRate($request);

        /*$duplicate_check = Review::where('lecture_id', $lecture->id)->where('user_id', Auth::id())->exists(); //レビュー重複チェック
        if($duplicate_check){
          return redirect()->back()->with('error', '1つの講義に対して2件目のレビューはできません。');
        }else {
          Review::create($input);
        }*/

        $review->create($input);
        return to_route('lecture.index');
    }
}
