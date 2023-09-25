<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LectureBookmark;
use App\Models\LectureDeleteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Lecture;
use App\Models\LectureCategory;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;
use App\Models\Review;
use App\Http\Requests\LectureRequest;
use Illuminate\Support\Facades\DB;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        $lectures = Lecture::searchByName($request->search_name, $request->exact)
            ->withCount('reviews', 'lecture_bookmarks')
            ->withAvg('reviews as average_rate', 'average_rate')
            ->get();

        $bookmarked_lecture_id = LectureBookmark::select('lecture_id')
            ->where('user_id', Auth::id())->get();

        return Inertia::render('Lecture/Index')->with([
            'lectures' => $lectures,
            'names' => Lecture::select('lecture_name', 'professor_name')->get(),
            'BookmarkedLectureId' => $bookmarked_lecture_id,
            'lectureCategories' => LectureCategory::get(),
            'faculties' => Faculty::get(),
        ]);
    }
    public function show($lecture_id)
    {
        $lecture = Lecture::with('reviews.user')
          ->withCount('reviews')
          ->withAvg('reviews as average_rate', 'average_rate')
          ->withAvg('reviews as fulfillment_rate_avg', 'fulfillment_rate')
          ->withAvg('reviews as ease_rate_avg', 'ease_rate')
          ->withAvg('reviews as satisfaction_rate_avg', 'satisfaction_rate')
          ->find($lecture_id);

        $fulfillment_rate = DB::table('reviews')->select('fulfillment_rate')
          ->selectRaw('COUNT(fulfillment_rate) as count')
          ->groupBy('fulfillment_rate')
          ->get();

        $ease_rate = DB::table('reviews')->select('ease_rate')
          ->selectRaw('COUNT(ease_rate) as count')
          ->groupBy('ease_rate')
          ->get();

        $satisfaction_rate = DB::table('reviews')->select('satisfaction_rate')
          ->selectRaw('COUNT(satisfaction_rate) as count')
          ->groupBy('satisfaction_rate')
          ->get();

        return Inertia::render('Lecture/Show')->with([
          'lecture' => $lecture,
          'category' => LectureCategory::select('name')->where('id', $lecture->lecture_category_id)->first(),
          'faculty' => Faculty::select('name')->where('id', $lecture->faculty_id)->first(),
          'department' => Department::select('name')->where('id', $lecture->department_id)->first(),
          'course' => Course::select('name')->where('id', $lecture->course_id)->first(),
          'fulfillmentRate' => $fulfillment_rate,
          'easeRate' => $ease_rate,
          'satisfactionRate' => $satisfaction_rate,
        ]);
    }

    public function create()
    {
        return Inertia::render('Lecture/Create')->with([
            'lectures' => Lecture::all(),
            'faculties' => Faculty::all(),
            'departments' => Department::all(),
            'courses' => Course::all(),
            'lectureCategories' => LectureCategory::all()
        ]);
    }

    public function store(LectureRequest $request, Lecture $lecture)
    {
        $input = $request->validated();
        $input['user_id'] = Auth::id();
        $lecture->fill($input)->save();

        return redirect()->back()->with('createdLectureId', $lecture->id);
    }
}
