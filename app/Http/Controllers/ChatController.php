<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Thread;
use App\Models\ThreadCategory;
use App\Models\Response;
use App\Http\Requests\ThreadRequest;
use App\Http\Requests\ResponseRequest;

class ChatController extends Controller
{
    public function index(Request $request, Thread $thread)
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
        Thread::create($input);
    }

    public function storeResponse($thread_id, ResponseRequest $request)
    {
        $input = $request->validated();
        $input['thread_id'] = $thread_id;
        Response::create($input);
    }
}
