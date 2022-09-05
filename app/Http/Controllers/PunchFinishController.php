<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Employee;
use App\Models\Customer;
use App\Models\CustomerGroup;

use App\Services\PunchFinishService;

class PunchFinishController extends Controller
{
    public function index()
    {
        // 自拠点の従業員情報を取得
        $employees = Employee::where('base_id', Auth::user()->base_id)->has('punch_finish_targets')->get();
        // 自拠点の荷主情報を取得
        $customers = Customer::where('control_base_id', Auth::user()->base_id)->get();
        $customer_groups = CustomerGroup::all();
        return view('punch.finish')->with([
            'employees' => $employees,
            'customers' => $customers,
            'customer_groups' => $customer_groups,
        ]);
    }

    public function input(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // サービスクラスを定義
        $PunchFinishService = new PunchFinishService;
        // 退勤時間調整を算出・取得
        $finish_time_adj = $PunchFinishService->getFinishTimeAdj($nowDate);
        // 労働時間を算出
        $working_time = $PunchFinishService->getWorkingTime($request->employee_no, $nowDate, $finish_time_adj);
        
        

        

        

        


        // 従業員情報を取得
        $employee = Employee::where('employee_no', $request->employee_no)->first();
        // 自拠点の荷主情報を取得
        $customers = Customer::where('control_base_id', Auth::user()->base_id)->get();
        $customer_groups = CustomerGroup::all();
        return view('punch.finish_input')->with([
            'finish_time' => $finish_time_adj,
            'working_time' => $working_time,
            'employee' => $employee,
            'customers' => $customers,
            'customer_groups' => $customer_groups,
        ]);
    }
}
