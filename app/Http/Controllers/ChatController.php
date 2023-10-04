<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LectureBookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Thread;
use App\Models\ThreadCategory;
use App\Models\Response;
use App\Http\Requests\ThreadRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class ChatController extends Controller
{
    public function index()
    {
        return Inertia::render('Chat/Index')->with([
            'threads' => Thread::all(),
            'threadCategories' => ThreadCategory::all(),
        ]);
    }

    public function store(ThreadRequest $request)
    {
        $input = $request->validated();
        if(Auth::check()){
            $input['user_id'] = Auth::id();
        }

        Thread::create($input);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
