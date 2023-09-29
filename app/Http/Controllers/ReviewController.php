<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
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
            ->with('lecture', 'tags', 'user')
            ->sort($request->sort)
            ->get();

        return Inertia::render('Review/Index')->with([
            'reviews' => $reviews,
            'resultCount' => $reviews->count(),
            'query'=> $request->query(),
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

        return to_route('lecture.index');
    }

    public function edit(Lecture $lecture, Review $review)
    {
        if(Auth::id() === $review->user_id ){ //url書き換え侵入対策
            return Inertia::render('Review/Edit')->with([
                'lecture' => $lecture,
                'review' => $review->with('tags')->find($review->id),
                'tags' => Tag::all()
            ]);
        }
        else {
            return redirect()->back();
        }
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

        return to_route('lecture.show', ['lecture' => $review->lecture_id]);
    }

    public function delete(Review $review)
    {
        if(Auth::id() === $review->user_id ){ //url書き換え侵入対策
            $review->delete();
            return redirect()->back();
        }
        else {
            return redirect()->back();
        }
    }
}
