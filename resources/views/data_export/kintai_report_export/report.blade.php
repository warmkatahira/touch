<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            @font-face {
                font-family: ipaexg;
                font-style: normal;
                font-weight: normal;
                src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
            }
            @font-face {
                font-family: ipaexg;
                font-style: bold;
                font-weight: bold;
                src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
            }
            body {
                font-family: ipaexg !important;
            }
            @page {
                margin-top: 0px;
                margin-bottom: 0px;
                margin-right: 0px;
                margin-left: 10px;
            }
        </style>
        <link rel="stylesheet" href="{{ public_path('css/kintai_report_output.css') }}">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ public_path('css/app.css') }}">
    </head>
    <body style="font-family: ipaexg">
        <!-- 表紙 -->
        <p class="top_page_title">{{ '勤怠表≪'.\Carbon\Carbon::parse($month)->isoFormat('Y年MM月').'≫' }}</p>
        <div class="info_parent">
            <span class="info_label">拠点</span>
            <span class="info_text">{{ $base['base']->base_name }}</span>
        </div>
        @foreach($base['total_employee'] as $employee_category_name => $total_employee)
            <div class="info_parent">
                <span class="info_label">{{ $employee_category_name }}</span>
                <span class="info_text">{{ $total_employee.'人' }}</span>
            </div>
        @endforeach
        <!-- 各従業員勤怠表 -->
        @foreach($kintais as $employee_no => $kintai)
            <p class="title">勤怠表</p>
            <div class="info_parent">
                <span class="info_label">拠点</span>
                <span class="info_text">{{ $kintai['base_name'] }}</span>
            </div>
            <div class="info_parent">
                <span class="info_label">従業員番号</span>
                <span class="info_text">{{ $employee_no }}</span>
            </div>
            <div class="info_parent">
                <span class="info_label">従業員区分</span>
                <span class="info_text">{{ $kintai['employee_category_name'] }}</span>
            </div>
            <div class="info_parent">
                <span class="info_label">従業員名</span>
                <span class="info_text">{{ $kintai['employee_name'] }}</span>
            </div>
            <div class="info_parent">
                <span class="info_label">稼働日数</span>
                <span class="info_text">{{ $kintai['working_days'].'日' }}</span>
            </div>
            <div class="info_parent">
                <span class="info_label">総稼働時間</span>
                <span class="info_text">{{ number_format($kintai['total_working_time'] / 60, 2).'時間' }}</span>
            </div>
            <div class="info_parent">
                <span class="info_label">総残業時間</span>
                <span class="info_text">{{ number_format($kintai['total_over_time'] / 60, 2).'時間' }}</span>
            </div>
            <div class="info_parent">
                <span class="info_label">祝日総稼働時間</span>
                <span class="info_text">{{ number_format($kintai['national_holiday_total_working_time'] / 60, 2).'時間' }}</span>
            </div>
            <table class="kintai_table">
                <thead>
                    <tr>
                        <th>出勤日</th>
                        <th>出勤</th>
                        <th>退勤</th>
                        <th>休憩</th>
                        <th>外出</th>
                        <th>戻り</th>
                        <th>稼働</th>
                        <th>残業</th>
                        <th>早出</th>
                        <th>コメント</th>
                        <th>超過</th>
                        <!-- 第1営業所のみ表示 -->
                        @if($kintai['base_id'] == 'warm_02')
                            <th>大洋</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($kintai['kintai'] as $work_day => $value)
                        <tr>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ \Carbon\Carbon::parse($work_day)->isoFormat('MM月DD日(ddd)') }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : substr($value->begin_time_adj, 0, 5) }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : substr($value->finish_time_adj, 0, 5) }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : number_format($value->rest_time / 60, 2) }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : substr($value->out_time_adj, 0, 5) }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : substr($value->return_time_adj, 0, 5) }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : number_format($value->working_time / 60, 2) }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : number_format($value->over_time / 60, 2) }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : ($value->is_early_worked == 1 ? '○' : '') }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ is_null($value) ? '' : $value->comment }}</td>
                            <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ \Carbon\Carbon::parse($work_day)->isSunday() && isset($over40[$employee_no]) ? (isset($over40[$employee_no][$work_day]) ? ($over40[$employee_no][$work_day]->over40 > 0 ? number_format($over40[$employee_no][$work_day]->over40 / 60, 2) : '0.00') : '0.00') : '' }}</td>
                            <!-- 第1営業所のみ表示 -->
                            @if($kintai['base_id'] == 'warm_02')
                                <td style="{{ \Carbon\Carbon::parse($work_day)->dayOfWeekIso >= 6 || isset($holidays[$work_day]) ? 'background-color: #CCFFFF' : '' }}">{{ isset($taiyo_working_times[$employee_no][$work_day]) ? '○' : '' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- 勤務表下部の計算欄 -->
            <div class="calc_field_parent_div">
                <div class="calc_field_child_div">
                    <p><p class="calc_field_1">時給単価</p><p class="calc_field_1">×</p><p class="calc_field_1">=</p></p>
                    <p><p class="calc_field_1">時給単価</p><p class="calc_field_1">×</p><p class="calc_field_1">=</p></p>
                    <p><p class="calc_field_1">交通費</p><p class="calc_field_1">×</p><p class="calc_field_1">=</p></p>
                </div>
                <p><p class="calc_field_2">合計</p><p class="calc_field_1">=</p></p>
            </div>
            <!-- 応援稼働がある場合のみ出力 -->
            @if(count($kintai['support_working_time']) != 0)
                <p class="title">応援稼働時間表</p>
                <div class="info_parent">
                    <span class="info_label">年月</span>
                    <span class="info_text">{{ \Carbon\Carbon::parse($month)->isoFormat('Y年MM月') }}</span>
                </div>
                <div class="info_parent">
                    <span class="info_label">拠点</span>
                    <span class="info_text">{{ $kintai['base_name'] }}</span>
                </div>
                <div class="info_parent">
                    <span class="info_label">従業員番号</span>
                    <span class="info_text">{{ $employee_no }}</span>
                </div>
                <div class="info_parent">
                    <span class="info_label">従業員名</span>
                    <span class="info_text">{{ $kintai['employee_name'] }}</span>
                </div>
                <table class="kintai_table">
                    <thead>
                        <tr>
                            <th>応援先拠点名</th>
                            <th>稼働時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kintai['support_working_time'] as $support_working_time)
                            <tr>
                                <td>{{ $support_working_time->customer_name }}</td>
                                <td style="text-align: right;">{{ number_format($support_working_time->total_customer_working_time / 60, 2).'時間' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    </body>
</html>
