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
        </style>
        <link rel="stylesheet" href="{{ public_path('css/kintai_report_output.css') }}">
    </head>
    <body style="font-family: ipaexg">
        <!-- 表紙 -->
        <p class="top_page_title">{{ '勤怠表≪'.\Carbon\Carbon::parse($month)->isoFormat('Y年MM月').'≫≪通常≫' }}</p>
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
            <table class="kintai_table">
                <thead>
                    <tr>
                        <th>出勤日</th>
                        <th>出勤</th>
                        <th>退勤</th>
                        <th>休憩取得</th>
                        <th>休憩未取得</th>
                        <th>外出</th>
                        <th>戻り</th>
                        <th>稼働</th>
                        <th>残業</th>
                        <th>早出</th>
                        <th>手動</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kintai['kintai'] as $work_day => $value){
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($work_day)->isoFormat('MM月DD日(ddd)') }}</td>
                            @if(is_null($value))
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @else
                                <td>{{ substr($value->begin_time_adj, 0, 5) }}</td>
                                <td>{{ substr($value->finish_time_adj, 0, 5) }}</td>
                                <td>{{ number_format($value->rest_time / 60, 2) }}</td>
                                <td>{{ number_format($value->no_rest_time / 60, 2) }}</td>
                                <td>{{ substr($value->out_time_adj, 0, 5) }}</td>
                                <td>{{ substr($value->return_time_adj, 0, 5) }}</td>
                                <td>{{ number_format($value->working_time / 60, 2) }}</td>
                                <td>{{ number_format($value->over_time / 60, 2) }}</td>
                                <td>{{ $value->is_early_worked == 1 ? '○' : '' }}</td>
                                <td>{{ $value->is_manual_punched == 1 ? '○' : '' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </body>
</html>
