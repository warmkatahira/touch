<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PunchController;
use App\Http\Controllers\PunchBeginController;
use App\Http\Controllers\PunchFinishController;
use App\Http\Controllers\PunchOutController;
use App\Http\Controllers\PunchReturnController;
use App\Http\Controllers\KintaiCheckController;
use App\Http\Controllers\ThisMonthKintaiController;
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
    Route::controller(PunchController::class)->prefix('punch')->name('punch.')->group(function(){
        Route::get('/', 'index')->name('index');
    });

    // 出勤打刻
    Route::controller(PunchBeginController::class)->prefix('punch_begin')->name('punch_begin.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('enter', 'enter')->name('enter');
    });

    // 退勤打刻
    Route::controller(PunchFinishController::class)->prefix('punch_finish')->name('punch_finish.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('input', 'input')->name('input');
        Route::post('enter', 'enter')->name('enter');
    });

    // 外出打刻
    Route::controller(PunchOutController::class)->prefix('punch_out')->name('punch_out.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('enter', 'enter')->name('enter');
    });

    // 戻り打刻
    Route::controller(PunchReturnController::class)->prefix('punch_return')->name('punch_return.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('enter', 'enter')->name('enter');
    });

    // 今日の勤怠
    Route::controller(KintaiCheckController::class)->prefix('today_kintai')->name('today_kintai.')->group(function(){
        Route::get('/', 'index')->name('index');
    });

    // 今月の勤怠
    Route::controller(ThisMonthKintaiController::class)->prefix('this_month_kintai')->name('this_month_kintai.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('detail', 'detail')->name('detail');
    });

    // 勤怠一覧
    Route::controller(KintaiListController::class)->prefix('kintai_list')->name('kintai_list.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('search', 'search')->name('search');
        Route::get('detail', 'detail')->name('detail');
        Route::post('manager_check', 'manager_check')->name('manager_check');
    });

    // 勤怠修正
    Route::controller(PunchModifyController::class)->prefix('punch_modify')->name('punch_modify.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('input', 'input')->name('input');
        Route::post('enter', 'enter')->name('enter');
    });

    // 勤怠削除
    Route::controller(KintaiDeleteController::class)->prefix('kintai_delete')->name('kintai.')->group(function(){
        Route::get('/', 'delete')->name('delete');
    });

    // 従業員一覧
    Route::controller(EmployeeListController::class)->prefix('employee_list')->name('employee_list.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('search', 'search')->name('search');
        Route::get('detail', 'detail')->name('detail');
        Route::get('modify', 'modify')->name('modify');
    });

    // 従業員マスタ操作関連
    Route::controller(EmployeeController::class)->prefix('employee')->name('employee.')->group(function(){
        Route::get('register', 'register_index')->name('register_index');
        Route::post('register', 'register')->name('register');
        Route::post('modify', 'modify')->name('modify');
    });

    // 手動打刻
    Route::controller(PunchManualController::class)->prefix('punch_manual')->name('punch_manual.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('input', 'input')->name('input');
        Route::post('enter', 'enter')->name('enter');
    });

    // 勤怠表出力
    Route::controller(KintaiReportOutputController::class)->prefix('kintai_report_output')->name('kintai_report_output.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('output', 'output')->name('output');
    });

    // 勤怠タグ
    Route::controller(KintaiTagController::class)->prefix('kintai_tag')->name('kintai_tag.')->group(function(){
        Route::post('register', 'register')->name('register');
        Route::get('delete', 'delete')->name('delete');
    });

    // 残業ランキング
    Route::controller(OverTimeRankController::class)->prefix('over_time_rank')->name('over_time_rank.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('search', 'search')->name('search');
    });

    // システム管理
    Route::controller(SystemMgtController::class)->prefix('system_mgt')->name('system_mgt.')->group(function(){
        Route::get('/', 'index')->name('index');
    });

    // ユーザー管理
    Route::controller(UserMgtController::class)->prefix('user_mgt')->name('user_mgt.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('detail', 'detail')->name('detail');
        Route::post('modify', 'modify')->name('modify');
    });

    // タグ管理
    Route::controller(TagMgtController::class)->prefix('tag_mgt')->name('tag_mgt.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('detail', 'detail')->name('detail');
        Route::get('register', 'register_index')->name('register_index');
        Route::post('register', 'register')->name('register');
        Route::get('delete', 'delete')->name('delete');
        Route::post('modify', 'modify')->name('modify');
    });

    // 荷主稼働ランキング
    Route::controller(CustomerWorkingTimeRankController::class)->prefix('customer_working_time_rank')->name('customer_working_time_rank.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('search', 'search')->name('search');
        Route::get('detail', 'detail')->name('detail');
    });
});