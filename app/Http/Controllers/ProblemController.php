<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProblemController extends Controller
{
    public function index(){
        return view('ploblems/index');
    }
}
