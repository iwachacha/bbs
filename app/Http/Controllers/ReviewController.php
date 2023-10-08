<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Lecture;
use App\Models\Review;
use App\Models\Tag;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function Index(Request $request)
    {
        $reviews = Review::query()
            ->searchByWord($request->search_word)
            ->filter($request->only(['fulfillment', 'ease', 'satisfaction', 'year']))
            ->searchByTag($request->tag)
            ->with('lecture', 'tags', 'user', 'reviewGoods')
            ->withCount('reviewGoods')
            ->sort($request->sort)
            ->paginate(8);

        return Inertia::render('Review/Index')->with([
            'reviews' => $reviews,
            'query'=> $request->except('page'),
            'totalCount' => Review::count()
        ]);
    }
    public function create(Lecture $lecture)
    {
        return Inertia::render('Review/Create')->with([
            'lecture' => $lecture,
            'tags' => Tag::all()
        ]);
    }

    public function store(Lecture $lecture, ReviewRequest $request, Review $review)
    {
        $input = $request->validated();
        $input['lecture_id'] = $lecture->id;
        $input['user_id'] = Auth::id();
        $input['average_rate'] = $review->getAverageRate($request);

        $duplicate_check = Review::where('lecture_id', $lecture->id)->where('user_id', Auth::id())->exists(); //レビュー重複チェック
        if($duplicate_check){
            return to_route('lecture.show', $lecture->id)->with('error', '1つの講義に対して2件目のレビューはできません。');
        }

        $review->fill($input)->save();

        foreach($input['tag'] as $tag){
            $created_tag = Tag::firstOrCreate(['name' => $tag]); //重複なしでタグを保存
            $review->tags()->attach($created_tag); //レビューとタグを紐付け
        }

        return to_route('lecture.show', $review->lecture_id);
    }

    public function edit(Lecture $lecture, Review $review)
    {
        //本人確認
        if(!Gate::inspect('update', $review)->allowed()) {
            return redirect()->back()->with('error', Gate::inspect('update', $review)->message());
        }

        return Inertia::render('Review/Edit')->with([
            'lecture' => $lecture,
            'review' => $review->with('tags')->find($review->id),
            'tags' => Tag::all()
        ]);
    }

    public function update(Review $review, ReviewRequest $request)
    {
        //本人確認
        if(!Gate::inspect('update', $review)->allowed()) {
            return redirect()->back()->with('error', Gate::inspect('update', $review)->message());
        }

        $input = $request->validated();
        $input['average_rate'] = $review->getAverageRate($request);
        $review->fill($input)->save();

        $review->tags()->detach(); //レビューとタグの紐付け解除
        foreach($input['tag'] as $tag){
            $created_tag = Tag::firstOrCreate(['name' => $tag]); //重複なしでタグ保存
            $review->tags()->attach($created_tag); //レビューとタグを紐付け
        }

        return to_route('lecture.show', ['lecture' => $review->lecture_id]);
    }

    public function delete(Review $review)
    {
        //本人確認
        if(!Gate::inspect('delete', $review)->allowed()) {
            return redirect()->back()->with('error', Gate::inspect('delete', $review)->message());
        }

        $review->delete();
        return redirect()->back();
    }
}
