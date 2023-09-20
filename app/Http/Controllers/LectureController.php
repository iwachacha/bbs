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
use App\Http\Requests\LectureRequest;
use Illuminate\Support\Facades\DB;

class LectureController extends Controller
{
    public function index(Lecture $lecture)
    {
        $lectures = $lecture->withCount('reviews', 'lecture_bookmarks')
            ->withAvg('reviews as average_rate', 'average_rate')
            ->get();

        $bookmarked_lecture_id = LectureBookmark::select('lecture_id')
            ->where('user_id', Auth::id())->get();

        return Inertia::render('Lecture/Index')->with([
            'lectures' => $lectures,
            'BookmarkedLectureId' => $bookmarked_lecture_id,
            'lectureCategories' => LectureCategory::get(),
            'faculties' => Faculty::get(),
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
        $lecture->fill($input)->save();

        return redirect()->back()->with('createdLectureId', $lecture->id);
    }
}
