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
        //対象レビューに既にgoodが存在すれば数を増やし、存在しなければ新しく作成
        if($review->user_id !== Auth::id()){
            if(ReviewGood::where('review_id', $review->id)->exists()){
                $review->review_good->increment('count', $request->count);
            }
            else {
                ReviewGood::create([
                    'review_id' => $review->id,
                    'count' => $request->count
                ]);
            }
        }
    }
}