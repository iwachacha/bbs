<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Lecture;

class LectureBookmarkController extends Controller
{
    public function set(Lecture $lecture)
    {
        $lecture->bookmarkUsers()->attach(Auth::id()); //重複なしで紐付け=ブックマーク登録
    }

    public function remove(Lecture $lecture)
    {
        $lecture->bookmarkUsers()->detach(Auth::id()); //紐付け解除＝ブックマーク解除
    }
}