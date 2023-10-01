<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function create()
    {
        return Inertia::render('Admin/Contact/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:500'],
        ]);

        $input = $request->all();
        Auth::check() && $input['user_id'] = Auth::id();
        Contact::create($input);
    }
}
