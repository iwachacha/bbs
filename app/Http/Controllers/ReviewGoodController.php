<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewGood;
use Illuminate\Support\Facades\Auth;

class ReviewGoodController extends Controller
{
    public function good(Review $review, Request $request)
    {
        //投稿者本人はgood不可
        //対象レビューにユーザーが既にgoodをしていれば数を増やし、していなければ新しく作成
        if($review->user_id !== Auth::id()){
            if(ReviewGood::where('review_id', $review->id)->where('user_id', Auth::id())->exists()){
                ReviewGood::where('review_id', $review->id)
                    ->where('user_id', Auth::id())
                    ->increment('count', $request->count);
            }
            else {
                ReviewGood::create([
                    'user_id' => Auth::id(),
                    'review_id' => $review->id,
                    'count' => $request->count
                ]);
            }
        }
    }
}