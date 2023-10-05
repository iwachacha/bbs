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
use App\Http\Requests\ResponseRequest;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $threads = Thread::query()
            ->searchByTitle($request->search_title)
            ->filter($request->category)
            ->with('thread_category', 'latestResponse')
            ->withCount('responses')
            ->sort($request->sort)
            ->paginate(20);

        return Inertia::render('Chat/Index')->with([
            'threads' => $threads,
            'threadCategories' => ThreadCategory::all(),
            'query'=> $request->except('page'),
            'totalCount' => Thread::count()
        ]);
    }

    public function show($thread_id)
    {
        return Inertia::render('Chat/Show')->with([
            'thread' => Thread::with('responses.user')->find($thread_id),
        ]);
    }

    public function storeThread(ThreadRequest $request)
    {
        $input = $request->validated();
        if(Auth::check()){
            $input['user_id'] = Auth::id();
        }

        Thread::create($input);
    }

    public function storeResponse($thread_id, ResponseRequest $request)
    {
        $input = $request->validated();
        $input['thread_id'] = $thread_id;
        if(Auth::check()){
            $input['user_id'] = Auth::id();
        }

        Response::create($input);
    }
}
