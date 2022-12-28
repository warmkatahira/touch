<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PunchFinishCheckMail;
use App\Models\Kintai;
use App\Models\User;
use App\Models\Base;
use Carbon\Carbon;

class PunchFinishCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'no_punch_finish_warning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '退勤漏れの勤怠をチェックし、管理者へメールで情報を送信';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 今日の日付を取得
        $nowDate = new Carbon('today');
        $nowDate = $nowDate->startOfMonth()->toDateString();
        // 拠点を取得
        $bases = Base::all();
        // 拠点分だけループ処理
        foreach($bases as $base){
            // 未退勤の勤怠を取得
            $kintais = Kintai::whereHas('employee', function($query) use ($base, $nowDate) {
                            $query->where('base_id', $base->base_id);
                        })
                        ->whereNull('finish_time');
            // 未退勤の勤怠があればメール送信の処理に入る
            if($kintais->exists()){
                // 未退勤の勤怠情報を取得
                $kintais = $kintais->get();
                // メール送信先を取得(該当拠点の管理者ロール)
                $users = User::where('base_id', $base->base_id)
                            ->where('role_id', 31)
                            ->get(['email']);
                // メールアドレスを配列に格納
                $to = [];
                foreach($users as $user){
                    array_push($to, $user->email);
                }
                // メール送信処理
                Mail::send(new PunchFinishCheckMail($base->base_name, $to, $kintais, $nowDate));
            }
        }
    }
}
