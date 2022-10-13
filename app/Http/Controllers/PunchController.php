<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PunchController extends Controller
{
    public function index()
    {
        return view('punch.index');
    }
}
