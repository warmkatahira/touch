<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PunchController;
use App\Http\Controllers\PunchBeginController;
use App\Http\Controllers\PunchFinishController;
use App\Http\Controllers\PunchOutController;
use App\Http\Controllers\PunchReturnController;
use App\Http\Controllers\KintaiCheckController;
use App\Http\Controllers\KintaiListController;
use App\Http\Controllers\KintaiModifyController;

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

// 打刻メニュー
Route::controller(PunchController::class)->group(function(){
    Route::get('/punch', 'index')->name('punch.index');
});

// 出勤打刻
Route::controller(PunchBeginController::class)->group(function(){
    Route::get('/punch_begin', 'index')->name('punch_begin.index');
    Route::post('/punch_begin_enter', 'enter')->name('punch_begin.enter');
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
});

// 勤怠修正
Route::controller(KintaiModifyController::class)->group(function(){
    Route::get('/kintai_modify', 'index')->name('kintai_modify.index');
    Route::get('/kintai_modify_input', 'input')->name('kintai_modify.input');
});