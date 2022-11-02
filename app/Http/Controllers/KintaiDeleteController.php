<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kintai;

class KintaiDeleteController extends Controller
{
    public function delete(Request $request)
    {
        // 勤怠を削除
        Kintai::where('kintai_id', $request->kintai_id)->delete();
        return redirect(session('back_url_1'));
    }
}
