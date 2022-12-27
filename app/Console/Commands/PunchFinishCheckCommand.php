<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PunchFinishCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:no_punch_finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '退勤漏れの勤怠をチェックし、管理者へメールを送信';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ここに書いた処理が実際に定期実行される処理！！！
        \Log::info('ログ出力テスト - command');
    }
}
