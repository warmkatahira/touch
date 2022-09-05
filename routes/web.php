<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PunchBeginController;
use App\Http\Controllers\PunchFinishController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// 出勤打刻
Route::controller(PunchBeginController::class)->group(function(){
    Route::get('/punch_menu', 'menu')->name('punch.menu');
    Route::get('/punch_begin', 'index')->name('punch_begin.index');
    Route::post('/punch_begin_confirm', 'confirm')->name('punch_begin.confirm');
});

// 退勤打刻
Route::controller(PunchFinishController::class)->group(function(){
    Route::get('/punch_finish', 'index')->name('punch_finish.index');
    Route::get('/punch_finish_input', 'input')->name('punch_finish.input');
});



require __DIR__.'/auth.php';
