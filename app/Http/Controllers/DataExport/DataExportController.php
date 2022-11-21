<?php

namespace App\Http\Controllers\DataExport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataExportController extends Controller
{
    public function index()
    {
        return view('data_export.index');
    }
}
