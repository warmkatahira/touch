<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class TodayKintaiController extends Controller
{
    public function index()
    {
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)
                        ->orderBy('employee_no')
                        ->get();
        return view('today_kintai.index')->with([
            'employees' => $employees,
        ]);
    }
}
