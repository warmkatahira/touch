<?php

namespace App\Http\Controllers\SystemMgt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemMgtController extends Controller
{
    public function index()
    {
        return view('system_mgt.index');
    }
}
