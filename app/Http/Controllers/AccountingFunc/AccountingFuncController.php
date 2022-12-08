<?php

namespace App\Http\Controllers\AccountingFunc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountingFuncController extends Controller
{
    public function index()
    {
        return view('accounting_func.index');
    }
}
