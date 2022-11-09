<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemMgtController extends Controller
{
    public function index()
    {
        return view('system_mgt.index');
    }
}
