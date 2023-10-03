<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LectureBookmark;
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
use App\Models\Tag;
use App\Http\Requests\LectureRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        $lectures = Lecture::query()
            ->searchByName($request->search_name, $request->exact)
            ->searchByLectureName($request->lecture_name)
            ->searchByProfessorName($request->professor_name)
            ->selectFilter($request->only(['season', 'category', 'faculty', 'department']))
            ->with('lecture_category', 'faculty', 'department', 'course', 'user')
            ->withCount('reviews', 'lecture_bookmarks')
            ->withAvg('reviews as average_rate', 'average_rate')
            ->withAvg('reviews as fulfillment_rate_avg', 'fulfillment_rate')
            ->withAvg('reviews as ease_rate_avg', 'ease_rate')
            ->withAvg('reviews as satisfaction_rate_avg', 'satisfaction_rate')
            ->ratingFilter($request->only(['fulfillment', 'ease', 'satisfaction']))
            ->sort($request->sort)
            ->paginate(12);

        return Inertia::render('Lecture/Index')->with([
            'lectures' => $lectures,
            'names' => fn() => Lecture::select('lecture_name', 'professor_name')->get(),
            'BookmarkedLectureId' => fn() => LectureBookmark::select('lecture_id')->where('user_id', Auth::id())->get(),
            'lectureCategories' => fn() => LectureCategory::all(),
            'faculties' => fn() => Faculty::all(),
            'departments' => fn() => Department::all(),
            'query'=> $request->except('page'),
            'totalCount' => Lecture::count()
        ]);
    }
    public function show($lecture_id, Request $request, Review $review)
    {
        $lecture = Lecture::query()
            ->with('lecture_category', 'faculty', 'department', 'course')
            ->withCount('reviews')
            ->withAvg('reviews as average_rate', 'average_rate')
            ->withAvg('reviews as fulfillment_rate_avg', 'fulfillment_rate')
            ->withAvg('reviews as ease_rate_avg', 'ease_rate')
            ->withAvg('reviews as satisfaction_rate_avg', 'satisfaction_rate')
            ->find($lecture_id);

        $reviews = Review::where('lecture_id', $lecture_id)
            ->filter($request->only(['fulfillment', 'ease', 'satisfaction', 'year']))
            ->with('user', 'tags', 'review_good')
            ->sort($request->sort)
            ->get();

        //各評価の星1~5それぞれの合計数
        $fulfillment_ratings = DB::table('reviews')
            ->where('lecture_id', $lecture_id)
            ->select('fulfillment_rate')
            ->selectRaw('COUNT(fulfillment_rate) as count')
            ->groupBy('fulfillment_rate')
            ->get();

        $ease_ratings = DB::table('reviews')
            ->where('lecture_id', $lecture_id)
            ->select('ease_rate')
            ->selectRaw('COUNT(ease_rate) as count')
            ->groupBy('ease_rate')
            ->get();

        $satisfaction_ratings = DB::table('reviews')
            ->where('lecture_id', $lecture_id)
            ->select('satisfaction_rate')
            ->selectRaw('COUNT(satisfaction_rate) as count')
            ->groupBy('satisfaction_rate')
            ->get();

        return Inertia::render('Lecture/Show')->with([
            'lecture' => fn() => $lecture,
            'reviews' => $reviews,
            'fulfillmentRatings' => fn() => $fulfillment_ratings,
            'easeRatings' => fn() => $ease_ratings,
            'satisfactionRatings' => fn() => $satisfaction_ratings,
            'query'=> $request->query(),
            'resultCount' => $reviews->count(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Lecture/Create')->with([
            'lectures' => fn() => Lecture::all(),
            'faculties' => fn() => Faculty::all(),
            'departments' => fn() => Department::all(),
            'courses' => fn() => Course::all(),
            'lectureCategories' => fn() => LectureCategory::all(),
            'tags' => fn() => Tag::all()
        ]);
    }

    public function store(LectureRequest $request, Lecture $lecture)
    {
        $input = $request->validated();
        $input['user_id'] = Auth::id();
        $lecture->fill($input)->save();

        return redirect()->back()->with('createdLectureId', $lecture->id);
    }

    public function edit(Lecture $lecture)
    {
        //本人確認＋他のユーザーが対象講義にレビューを投稿していないか確認
        if(!Gate::inspect('update', $lecture)->allowed()) {
            return redirect()->back()->with('error', Gate::inspect('update', $lecture)->message());
        }

        if(!Gate::inspect('checkReview', $lecture)->allowed()) {
            return redirect()->back()->with('error', Gate::inspect('checkReview', $lecture)->message());
        }

        return Inertia::render('Lecture/Edit')->with([
            'lecture' => $lecture,
            'faculties' => Faculty::all(),
            'departments' => Department::all(),
            'courses' => Course::all(),
            'lectureCategories' => LectureCategory::all(),
        ]);
    }

    public function update(Lecture $lecture, LectureRequest $request)
    {
        $input = $request->validated();
        $lecture->fill($input)->save();

        return to_route('lecture.show', $lecture->id);
    }

    public function destroy(Lecture $lecture)
    {
        //本人確認＋他のユーザーが対象講義にレビューを投稿していないか確認
        if(!Gate::inspect('delete', $lecture)->allowed()) {
            return redirect()->back()->with('error', Gate::inspect('delete', $lecture)->message());
        }

        if(!Gate::inspect('checkReview', $lecture)->allowed()) {
            return redirect()->back()->with('error', Gate::inspect('checkReview', $lecture)->message());
        }

        $lecture->delete();
        return redirect()->back();
    }
}
