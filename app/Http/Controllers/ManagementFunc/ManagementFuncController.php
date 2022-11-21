<?php

namespace App\Http\Controllers\ManagementFunc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementFuncController extends Controller
{
    public function index()
    {
        return view('management_func.index');
    }
}
