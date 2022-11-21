<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('this_month_kintai.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-2 col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">今月の勤怠詳細</p>
        </div>
        <div class="grid grid-cols-12 mt-5 text-xl">
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2">番号</p>
            <p class="col-span-1 border border-black py-2 text-center">{{ $employee->employee_no }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2">氏名</p>
            <p class="col-span-3 border border-black py-2 text-center">{{ $employee->employee_name }}</p>
        </div>
        <!-- 勤怠表 -->
        <div class="grid grid-cols-12 mt-5">
            <table class="col-span-12 text-xl">
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
