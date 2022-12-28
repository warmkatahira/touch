<div style="font-family: 游ゴシック;">
    <!-- ヘッダー -->
    <div style="">
        お疲れ様です。<br>
        退勤処理がされていない勤怠がありますので、処理をお願いします。
    </div>
    <br>
    <!-- 未退勤情報を出力 -->
    <table>
        <thead>
            <tr style="background-color:lightcyan; font-size: 1.0em;">
                <th style="border: 1px solid #ccc; padding: 0px 10px;">出勤日</th>
                <th style="border: 1px solid #ccc; padding: 0px 10px;">従業員名</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kintais as $kintai)
                <tr style="font-size: 1.0em;">
                    <td style="border: 1px solid #ccc; padding: 0px 10px;">{{ \Carbon\Carbon::parse($kintai->work_day)->isoFormat('YYYY年MM月DD日(ddd)') }}</td>
                    <td style="border: 1px solid #ccc; padding: 0px 10px;">{{ $kintai->employee->employee_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- フッター -->
    <div style="color: red;">
        ※このメールはシステムから自動配信されています。<br>
        ※このメールに返信されても返答はできませんので、ご注意下さい。
    </div>
    -----------------------------------------------------------------------<br>
    勤怠管理システム Touch
</div>