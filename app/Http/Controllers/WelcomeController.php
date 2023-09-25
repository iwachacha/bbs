<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class WelcomeController extends Controller
{
    public function welcome(User $user)
    {
        return Inertia::render('Welcome')->with([
            'userCount' => User::count(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
