<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;

class ProfileController extends Controller
{
    public function show($user_id)
    {
        $user = User::query()
            ->with('lectures', 'reviews', 'lectureBookmarks', 'reviewGoods', 'faculty', 'department', 'course')
            ->find($user_id);

        return Inertia::render('Profile/Show', [
            'user' => $user
        ]);
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            //'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'faculties' => Faculty::all(),
            'departments' => Department::all(),
            'courses' => Course::all(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        /*if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }*/

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
            'delete_confirm' => ['required', 'regex:/アカウント削除/']
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
