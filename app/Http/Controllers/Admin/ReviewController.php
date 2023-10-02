<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Lecture;
use App\Models\Review;
use App\Models\Tag;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function Index(Request $request)
    {
        $reviews = Review::query()
            ->searchByWord($request->search_word)
            ->filter($request->only(['fulfillment', 'ease', 'satisfaction', 'year']))
            ->searchByTag($request->tag)
            ->with('lecture', 'tags', 'user', 'review_good')
            ->sort($request->sort)
            ->paginate(8);

        return Inertia::render('Admin/Review/Index')->with([
            'reviews' => $reviews,
            'query'=> $request->except('page'),
            'totalCount' => Review::count()
        ]);
    }

    public function edit(Lecture $lecture, Review $review)
    {
        return Inertia::render('Admin/Review/Edit')->with([
            'lecture' => $lecture,
            'review' => $review->with('tags')->find($review->id),
            'tags' => Tag::all()
        ]);
    }

    public function update(Review $review, ReviewRequest $request)
    {
        $input = $request->validated();
        $input['average_rate'] = $review->getAverageRate($request);
        $review->fill($input)->save();

        $review->tags()->detach(); //レビューとタグの紐付け解除
        foreach($input['tag'] as $tag){
            $created_tag = Tag::firstOrCreate(['name' => $tag]); //重複なしでタグ保存
            $review->tags()->attach($created_tag); //レビューとタグを紐付け
        }

        return to_route('admin.lecture.show', ['lecture' => $review->lecture_id]);
    }

    public function delete(Review $review)
    {
        $review->delete();
        return redirect()->back();
    }
}
