<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GourmetController extends Controller
{
    public function index(){
        return view('gourmets/index');
    }
}
