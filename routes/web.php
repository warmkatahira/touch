<?php

use Illuminate\Support\Facades\Route;
// Punch
use App\Http\Controllers\Punch\PunchController;
use App\Http\Controllers\Punch\PunchBeginController;
use App\Http\Controllers\Punch\PunchFinishController;
use App\Http\Controllers\Punch\PunchOutController;
use App\Http\Controllers\Punch\PunchReturnController;
use App\Http\Controllers\Punch\PunchManualController;
use App\Http\Controllers\Punch\PunchModifyController;
// SystemMgt
use App\Http\Controllers\SystemMgt\SystemMgtController;
use App\Http\Controllers\SystemMgt\TagMgtController;
use App\Http\Controllers\SystemMgt\UserMgtController;
use App\Http\Controllers\SystemMgt\HolidayMgtController;
// Kintai
use App\Http\Controllers\Kintai\KintaiListController;
use App\Http\Controllers\Kintai\KintaiDeleteController;
use App\Http\Controllers\Kintai\KintaiTagController;
use App\Http\Controllers\Kintai\KintaiCommentController;
// Other
use App\Http\Controllers\Other\OtherController;
use App\Http\Controllers\Other\TodayKintaiController;
use App\Http\Controllers\Other\ThisMonthKintaiController;
use App\Http\Controllers\Other\OverTimeRankController;
use App\Http\Controllers\Other\CustomerWorkingTimeRankController;
// DataExport
use App\Http\Controllers\DataExport\DataExportController;
use App\Http\Controllers\DataExport\CsvExportController;
use App\Http\Controllers\DataExport\KintaiReportExportController;
// Employee
use App\Http\Controllers\Employee\EmployeeListController;
use App\Http\Controllers\Employee\EmployeeController;
// ManagementFunc
use App\Http\Controllers\ManagementFunc\ManagementFuncController;
use App\Http\Controllers\ManagementFunc\CustomerGroupController;
use App\Http\Controllers\ManagementFunc\KintaiCloseController;
// AccountingFunc
use App\Http\Controllers\AccountingFunc\AccountingFuncController;
use App\Http\Controllers\AccountingFunc\KintaiCloseCheckController;

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

// ??????????????????????????????????????????????????????????????????????????????????????????
Route::middleware(['auth','user.status'])->group(function () {
    // ??????????????????
    Route::controller(PunchController::class)->prefix('punch')->name('punch.')->group(function(){
        Route::get('/', 'index')->name('index');
    });
    // ??????????????????????????????????????????
    Route::middleware(['kintai.close.check'])->group(function () {
        // ????????????
        Route::controller(PunchBeginController::class)->prefix('punch_begin')->name('punch_begin.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::post('enter', 'enter')->name('enter');
        });

        // ????????????
        Route::controller(PunchFinishController::class)->prefix('punch_finish')->name('punch_finish.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('input', 'input')->name('input');
            Route::post('enter', 'enter')->name('enter');
        });

        // ????????????
        Route::controller(PunchOutController::class)->prefix('punch_out')->name('punch_out.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::post('enter', 'enter')->name('enter');
        });

        // ????????????
        Route::controller(PunchReturnController::class)->prefix('punch_return')->name('punch_return.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::post('enter', 'enter')->name('enter');
        });
    });

    // ???????????????
    Route::controller(TodayKintaiController::class)->prefix('today_kintai')->name('today_kintai.')->group(function(){
        Route::get('/', 'index')->name('index');
    });

    // ???????????????
    Route::controller(ThisMonthKintaiController::class)->prefix('this_month_kintai')->name('this_month_kintai.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('detail', 'detail')->name('detail');
    });

    // ????????????
    Route::controller(KintaiListController::class)->prefix('kintai_list')->name('kintai_list.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('search', 'search')->name('search');
        Route::get('detail', 'detail')->name('detail');
        Route::post('manager_check', 'manager_check')->name('manager_check');
    });

    // ????????????
    Route::controller(PunchModifyController::class)->prefix('punch_modify')->name('punch_modify.')->group(function(){
        Route::get('/', 'index')->name('index')->middleware('kintai.operation.check');
        Route::get('input', 'input')->name('input');
        Route::post('enter', 'enter')->name('enter');
    });

    // ????????????
    Route::controller(KintaiDeleteController::class)->prefix('kintai_delete')->name('kintai.')->middleware('kintai.operation.check')->group(function(){
        Route::get('/', 'delete')->name('delete');
    });

    // ??????????????????
    Route::controller(KintaiCommentController::class)->prefix('kintai_comment')->name('kintai_comment.')->middleware('kintai.operation.check')->group(function(){
        Route::get('/', 'update')->name('update');
    });

    // ???????????????
    Route::controller(EmployeeListController::class)->prefix('employee_list')->name('employee_list.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('search', 'search')->name('search');
        Route::get('detail', 'detail')->name('detail');
        Route::get('modify', 'modify')->name('modify');
    });

    // ??????????????????????????????
    Route::controller(EmployeeController::class)->prefix('employee')->name('employee.')->group(function(){
        Route::get('register', 'register_index')->name('register_index');
        Route::post('register', 'register')->name('register');
        Route::post('modify', 'modify')->name('modify');
    });

    // ????????????
    Route::controller(KintaiTagController::class)->prefix('kintai_tag')->name('kintai_tag.')->group(function(){
        Route::post('register', 'register')->name('register');
        Route::get('delete', 'delete')->name('delete');
    });

    // ??????????????????
    Route::controller(SystemMgtController::class)->prefix('system_mgt')->name('system_mgt.')->group(function(){
        Route::get('/', 'index')->name('index');
    });
        // ??????????????????
        Route::controller(UserMgtController::class)->prefix('user_mgt')->name('user_mgt.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('detail', 'detail')->name('detail');
            Route::post('modify', 'modify')->name('modify');
        });
        // ????????????
        Route::controller(TagMgtController::class)->prefix('tag_mgt')->name('tag_mgt.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('detail', 'detail')->name('detail');
            Route::get('register', 'register_index')->name('register_index');
            Route::post('register', 'register')->name('register');
            Route::get('delete', 'delete')->name('delete');
            Route::post('modify', 'modify')->name('modify');
        });
        // ????????????
        Route::controller(HolidayMgtController::class)->prefix('holiday_mgt')->name('holiday_mgt.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('export', 'export')->name('export');
            Route::post('import', 'import')->name('import');
        });
    // ???????????????
    Route::controller(DataExportController::class)->prefix('data_export')->name('data_export.')->group(function(){
        Route::get('/', 'index')->name('index');
    });
        // ???????????????
        Route::controller(KintaiReportExportController::class)->prefix('kintai_report_export')->name('kintai_report_export.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::post('export', 'export')->name('export');
        });
        // CSV??????
        Route::controller(CsvExportController::class)->prefix('csv_export')->name('csv_export.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('export', 'export')->name('export');
        });

    // ???????????????
    Route::controller(ManagementFuncController::class)->prefix('management_func')->name('management_func.')->group(function(){
        Route::get('/', 'index')->name('index');
    });
        // ????????????
        Route::controller(PunchManualController::class)->prefix('punch_manual')->name('punch_manual.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('input', 'input')->name('input')->middleware('kintai.close.check');
            Route::post('enter', 'enter')->name('enter');
        });
        // ????????????????????????
        Route::controller(CustomerGroupController::class)->prefix('customer_group')->name('customer_group.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('detail', 'detail')->name('detail');
            Route::get('delete_setting', 'delete_setting')->name('delete_setting');
            Route::post('register_setting', 'register_setting')->name('register_setting');
            Route::post('register_group', 'register_group')->name('register_group');
            Route::get('delete_group', 'delete_group')->name('delete_group');
            Route::post('modify', 'modify')->name('modify');
        });
        // ????????????
        Route::controller(KintaiCloseController::class)->prefix('kintai_close')->name('kintai_close.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('closing', 'closing')->name('closing');
        });

        // ?????????
        Route::controller(OtherController::class)->prefix('other')->name('other.')->group(function(){
            Route::get('/', 'index')->name('index');
        });
            // ?????????????????????
            Route::controller(OverTimeRankController::class)->prefix('over_time_rank')->name('over_time_rank.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('search', 'search')->name('search');
            });
            // ???????????????????????????
            Route::controller(CustomerWorkingTimeRankController::class)->prefix('customer_working_time_rank')->name('customer_working_time_rank.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('search', 'search')->name('search');
                Route::get('detail', 'detail')->name('detail');
            });
        // ????????????
        Route::controller(AccountingFuncController::class)->prefix('accounting_func')->name('accounting_func.')->group(function(){
            Route::get('/', 'index')->name('index');
        });
            // ??????????????????
            Route::controller(KintaiCloseCheckController::class)->prefix('kintai_close_check')->name('kintai_close_check.')->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('search', 'search')->name('search');
            });
});