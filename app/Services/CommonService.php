<?php

namespace App\Services;

use App\Models\Base;

class CommonService
{
    public function getBases($zensha_enabled)
    {
        // 拠点情報を取得
        $bases = Base::all();
        // 配列をセット
        $base_info = [];
        // zensha_enabledがtrueなら全社をセット
        if($zensha_enabled == true){
            $base_info[0] = '全社';
        }
        // baseテーブルのレコードをセット
        foreach($bases as $base){
            $base_info[$base->base_id] = $base->base_name;
        }
        return $base_info;
    }
}