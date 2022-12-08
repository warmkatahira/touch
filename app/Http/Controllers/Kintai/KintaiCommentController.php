<?php

namespace App\Http\Controllers\Kintai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kintai;

class KintaiCommentController extends Controller
{
    public function update(Request $request)
    {
        Kintai::where('kintai_id', $request->kintai_id)->update([
            'comment' => $request->comment,
        ]);
        return back();
    }
}
