<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Lecture;
use App\Models\Review;
use App\Models\Thread;


class HomeController extends Controller
{
    public function home(User $user)
    {
        return Inertia::render('Home')->with([
            'userCount' => User::count(),
            'lectures' => Lecture::orderBy('id', 'desc')->take(5)->get(),
            'reviews' => Review::orderBy('id', 'desc')->take(5)->get(),
            'threads' => Thread::orderBy('id', 'desc')->take(5)->get(),
        ]);
    }
}
