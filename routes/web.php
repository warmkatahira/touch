<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PunchController;
use App\Http\Controllers\PunchBeginController;
use App\Http\Controllers\PunchFinishController;
use App\Http\Controllers\PunchOutController;
use App\Http\Controllers\PunchReturnController;
use App\Http\Controllers\KintaiCheckController;
use App\Http\Controllers\KintaiListController;
use App\Http\Controllers\PunchModifyController;
use App\Http\Controllers\KintaiDeleteController;
use App\Http\Controllers\EmployeeListController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PunchManualController;
use App\Http\Controllers\KintaiReportOutputController;
use App\Http\Controllers\KintaiTagController;
use App\Http\Controllers\OverTimeRankController;
use App\Http\Controllers\SystemMgtController;
use App\Http\Controllers\TagMgtController;
use App\Http\Controllers\UserMgtController;
use App\Http\Controllers\CustomerWorkingTimeRankController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ログインしているか、ユーザーステータスが有効であるかチェック
Route::middleware(['auth','user.status'])->group(function () {
    // 打刻メニュー
    Route::controller(PunchController::class)->prefix('punch')->group(function(){
        Route::get('/', 'index')->name('punch.index');
    });

    // 出勤打刻
    Route::controller(PunchBeginController::class)->prefix('punch_begin')->group(function(){
        Route::get('/', 'index')->name('punch_begin.index');
        Route::post('enter', 'enter')->name('punch_begin.enter');
    });

    // 退勤打刻
    Route::controller(PunchFinishController::class)->group(function(){
        Route::get('/punch_finish', 'index')->name('punch_finish.index');
        Route::get('/punch_finish_input', 'input')->name('punch_finish.input');
        Route::post('/punch_finish_enter', 'enter')->name('punch_finish.enter');
    });

    // 外出打刻
    Route::controller(PunchOutController::class)->group(function(){
        Route::get('/punch_out', 'index')->name('punch_out.index');
        Route::post('/punch_out_enter', 'enter')->name('punch_out.enter');
    });

    // 戻り打刻
    Route::controller(PunchReturnController::class)->group(function(){
        Route::get('/punch_return', 'index')->name('punch_return.index');
        Route::post('/punch_return_enter', 'enter')->name('punch_return.enter');
    });

    // 今日の勤怠/今月の勤怠
    Route::controller(KintaiCheckController::class)->group(function(){
        Route::get('/today_kintai', 'today_kintai_index')->name('today_kintai.index');
        Route::get('/this_month_kintai', 'this_month_kintai_index')->name('this_month_kintai.index');
    });

    // 勤怠一覧
    Route::controller(KintaiListController::class)->group(function(){
        Route::get('/kintai_list', 'index')->name('kintai_list.index');
        Route::get('/kintai_list_search', 'search')->name('kintai_list.search');
        Route::get('/kintai_detail', 'detail')->name('kintai_list.detail');
        Route::post('/manager_check', 'manager_check')->name('manager_check');
    });

    // 勤怠修正
    Route::controller(PunchModifyController::class)->group(function(){
        Route::get('/punch_modify', 'index')->name('punch_modify.index');
        Route::get('/punch_modify_input', 'input')->name('punch_modify.input');
        Route::post('/punch_modify_enter', 'enter')->name('punch_modify.enter');
    });

    // 勤怠削除
    Route::controller(KintaiDeleteController::class)->group(function(){
        Route::get('/kintai_delete', 'delete')->name('kintai.delete');
    });

    // 従業員一覧
    Route::controller(EmployeeListController::class)->group(function(){
        Route::get('/employee_list', 'index')->name('employee_list.index');
        Route::get('/employee_list_search', 'search')->name('employee_list.search');
        Route::get('/employee_list_detail', 'detail')->name('employee_list.detail');
        Route::get('/employee_list_modify', 'modify')->name('employee_list.modify');
    });

    // 従業員マスタ操作関連
    Route::controller(EmployeeController::class)->group(function(){
        Route::get('/employee_register', 'register_index')->name('employee.register_index');
        Route::post('/employee_register', 'register')->name('employee.register');
        Route::post('/employee_modify', 'modify')->name('employee.modify');
    });

    // 手動打刻
    Route::controller(PunchManualController::class)->group(function(){
        Route::get('/punch_manual', 'index')->name('punch_manual.index');
        Route::get('/punch_manual_input', 'input')->name('punch_manual.input');
        Route::post('/punch_manual_enter', 'enter')->name('punch_manual.enter');
    });

    // 勤怠表出力
    Route::controller(KintaiReportOutputController::class)->group(function(){
        Route::get('/kintai_report_output', 'index')->name('kintai_report_output.index');
        Route::post('/kintai_report_output_normal', 'output_normal')->name('kintai_report_output_normal.output');
    });

    // 勤怠タグ
    Route::controller(KintaiTagController::class)->group(function(){
        Route::post('/kintai_tag_register', 'register')->name('kintai_tag.register');
        Route::get('/kintai_tag_delete', 'delete')->name('kintai_tag.delete');
    });

    // 残業ランキング
    Route::controller(OverTimeRankController::class)->group(function(){
        Route::get('/over_time_rank', 'index')->name('over_time_rank.index');
        Route::get('/over_time_rank_search', 'search')->name('over_time_rank.search');
    });

    // システム管理
    Route::controller(SystemMgtController::class)->group(function(){
        Route::get('/system_mgt', 'index')->name('system_mgt.index');
    });

    // ユーザー管理
    Route::controller(UserMgtController::class)->group(function(){
        Route::get('/user_mgt', 'index')->name('user_mgt.index');
        Route::get('/user_mgt_detail', 'detail')->name('user_mgt.detail');
        Route::post('/user_mgt_modify', 'modify')->name('user_mgt.modify');
    });

    // タグ管理
    Route::controller(TagMgtController::class)->group(function(){
        Route::get('/tag_mgt', 'index')->name('tag_mgt.index');
        Route::get('/tag_mgt_detail', 'detail')->name('tag_mgt.detail');
        Route::get('/tag_mgt_register_index', 'register_index')->name('tag_mgt.register_index');
        Route::post('/tag_mgt_register', 'register')->name('tag_mgt.register');
        Route::get('/tag_mgt_delete', 'delete')->name('tag_mgt.delete');
        Route::post('/tag_mgt_modify', 'modify')->name('tag_mgt.modify');
    });

    // 荷主稼働ランキング
    Route::controller(CustomerWorkingTimeRankController::class)->group(function(){
        Route::get('/customer_working_time_rank', 'index')->name('customer_working_time_rank.index');
        Route::get('/customer_working_time_rank_search', 'search')->name('customer_working_time_rank.search');
        Route::get('/customer_working_time_rank_detail', 'detail')->name('customer_working_time_rank.detail');
    });
});