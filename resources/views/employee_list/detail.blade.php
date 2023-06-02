<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_1') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-10 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">従業員詳細</p>
            <!-- 経理ロール以上もしくは拠点管理者ロールであり自拠点の従業員であればボタンを表示 -->
            @if(Auth::user()->role_id <= 11 || Auth::user()->role_id == 31 && Auth::user()->base_id == $employee->base_id)
                <a href="{{ route('employee_list.modify', ['employee_no' => $employee->employee_no]) }}" class="col-start-12 col-span-1 text-xl py-4 rounded-lg text-center bg-blue-200 mb-5">変更</a>
            @endif
        </div>
        <!-- 従業員情報 -->
        <div class="grid grid-cols-12">
            <p class="col-span-12 text-2xl mb-4 border-l-4 border-blue-500 pl-2">従業員情報</p>
            <label class="col-start-1 col-span-1 bg-black text-white py-2 text-center">拠点</label>
            <p class="col-span-2 border border-black px-2 pt-2">{{ $employee->base->base_name }}</p>
            <label class="col-span-1 bg-black text-white py-2 text-center">従業員区分</label>
            <p class="col-span-1 border border-black px-2 pt-2">{{ $employee->employee_category->employee_category_name }}</p>
            <label class="col-span-1 bg-black text-white py-2 text-center">従業員番号</label>
            <p id="employee_no" class="col-span-1 border border-black px-2 pt-2">{{ $employee->employee_no }}</p>
            <label class="col-span-1 bg-black text-white py-2 text-center">従業員名</label>
            <p class="col-span-2 border border-black px-2 pt-2">{{ $employee->employee_name }}</p>
            <label class="col-start-1 col-span-1 bg-black text-white py-2 text-center mt-1">月間稼働設定</label>
            <p class="col-span-1 border border-black px-2 pt-2 mt-1 text-right">{{ number_format($employee->monthly_workable_time_setting, 2) }}</p>
            <label class="col-span-2 bg-black text-white py-2 text-center mt-1">残業開始時間設定</label>
            <p class="col-span-1 border border-black px-2 pt-2 mt-1 text-right">{{ number_format($employee->over_work_start_setting, 2) }}</p>
        </div>
        <!-- 当月稼働情報 -->
        <div class="grid grid-cols-12 mt-5">
            <p class="col-span-12 text-2xl mb-4 border-l-4 border-blue-500 pl-2">当月稼働情報</p>
            <label class="col-start-1 col-span-1 bg-black text-white py-2 text-center">稼働日数</label>
            <p class="col-span-1 border border-black px-2 pt-2">{{ $working_days.'日' }}</p>
            <label class="col-span-1 bg-black text-white py-2 text-center">総稼働時間</label>
            <p class="col-span-1 border border-black px-2 pt-2 text-right">{{ number_format($total_working_time / 60, 2).' 時間' }}</p>
            <label class="col-span-1 bg-black text-white py-2 text-center">総残業時間</label>
            <p class="col-span-1 border border-black px-2 pt-2 text-right">{{ number_format($total_over_time / 60, 2).' 時間' }}</p>
        </div>
        <!-- 当月荷主別稼働時間トップ3情報 -->
        <div class="grid grid-cols-12 mt-5">
            <p class="col-span-12 text-2xl border-l-4 border-blue-500 pl-2">当月荷主別稼働時間トップ3</p>
            <p class="col-span-6 text-base mb-4 text-right underline text-red-600">※（）内は総稼働時間に対しての割合</p>
            @foreach($customer_working_time as $key => $data)
                <div class="col-start-1 col-span-6 grid grid-cols-12 border-dashed border-b-2 border-blue-600">
                    <p class="col-start-1 col-span-8"><span class="text-xl mr-5">{{ ($key + 1).'位' }}</span>{{ $data->customer_name }}</p>
                    <p class="col-span-4 text-right">{{ number_format(($data->total_customer_working_time / 60), 2).' 時間（'.number_format((($data->total_customer_working_time / $total_working_time) * 100),2).' %）' }}</p>
                </div>
            @endforeach
        </div>
        <!-- 勤怠表 -->
        <div class="grid grid-cols-12 mt-5">
            <p class="col-span-12 text-2xl border-l-4 border-blue-500 pl-2">勤怠表</p>
            <table class="col-span-12 text-sm mt-3">
                <thead>
                    <tr class="text-center text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th class="font-thin p-2 px-2 w-2/12">出勤日</th>
                        <th class="font-thin p-2 px-2 w-1/12">出勤</th>
                        <th class="font-thin p-2 px-2 w-1/12">退勤</th>
                        <th class="font-thin p-2 px-2 w-1/12">休憩取得</th>
                        <th class="font-thin p-2 px-2 w-1/12">休憩未取得</th>
                        <th class="font-thin p-2 px-2 w-1/12">外出</th>
                        <th class="font-thin p-2 px-2 w-1/12">戻り</th>
                        <th class="font-thin p-2 px-2 w-1/12">稼働</th>
                        <th class="font-thin p-2 px-2 w-1/12">残業</th>
                        <th class="font-thin p-2 px-2 w-1/12">早出</th>
                        <th class="font-thin p-2 px-2 w-1/12">手動</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kintais[$employee->employee_no]['kintai'] as $work_day => $value)
                        <tr class="hover:bg-teal-100 text-center">
                            <td class="p-1 px-2 border">{{ \Carbon\Carbon::parse($work_day)->isoFormat('YYYY年MM月DD日(ddd)') }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : substr($value->begin_time_adj, 0, 5) }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : substr($value->finish_time_adj, 0, 5) }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : number_format($value->rest_time / 60, 2) }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : number_format($value->no_rest_time / 60, 2) }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : substr($value->out_time_adj, 0, 5) }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : substr($value->return_time_adj, 0, 5) }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : number_format($value->working_time / 60, 2) }}</td>
                            <td class="p-1 px-2 border {{ is_null($value) ? '' : ($value->over_time == 0 ? '' : 'bg-pink-200') }}">{{ is_null($value) ? '' : number_format($value->over_time / 60, 2) }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : ($value->is_early_worked == 1 ? '○' : '') }}</td>
                            <td class="p-1 px-2 border">{{ is_null($value) ? '' : ($value->is_manual_punched == 1 ? '○' : '') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
