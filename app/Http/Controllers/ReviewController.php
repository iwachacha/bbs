<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LectureCategory;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Lecture $lecture, Review $review){
        return view('reviews/index')->with(['lecture' => $lecture, 'reviews' => $review::where('lecture_id', $lecture->id)->get()]);
    }
    
    public function show(Lecture $lecture, Review $review){
        return view('reviews/show')->with(['lecture' => $lecture, 'review' => $review]);
    }
    
    public function create(Lecture $lecture){
        return view('reviews/create')->with(['lecture' => $lecture]);
    }
    
    public function store(ReviewRequest $request, Lecture $lecture, Review $review){
        $review_input = $request['review'];
        $review_input['user_id'] = Auth::id();
        $review_input['lecture_id'] = $lecture->id;
        $review->fill($review_input)->save();
        return redirect()->route('review.index', ['lecture' => $lecture->id, 'review' => $review->id]);
    }
    
    public function edit(Lecture $lecture, Review $review){
        
        return view('reviews/edit')->with(['lecture' => $lecture, 'review' => $review]);
    }

    public function update(ReviewRequest $request, Lecture $lecture, Review $review)
    {
        $review_input = $request['review'];
        $review_input['user_id'] = Auth::id();
        $review_input['lecture_id'] = $lecture->id;
        $review->fill($review_input)->save();
        return redirect()->route('review.show', ['lecture' => $lecture->id, 'review' => $review->id]);
    }
}
