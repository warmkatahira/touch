<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('punch.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white hover:bg-sky-500 mb-5">戻る</a>
            <p class="col-start-4 col-span-6 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">今月の勤怠</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <table class="col-span-12">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-2/12">拠点</th>
                        <th class="font-thin p-2 px-2 w-1/12">番号</th>
                        <th class="font-thin p-2 px-2 w-4/12">氏名</th>
                        <th class="font-thin p-2 px-2 w-1/12">区分</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">稼働時間</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">残業時間</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($month_kintais as $month_kintai)
                        <tr class="hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $month_kintai->base_name }}</td>
                            <td class="p-1 px-2 border">{{ $month_kintai->employee_no }}</td>
                            <td class="p-1 px-2 border">{{ $month_kintai->employee_name }}</td>
                            <td class="p-1 px-2 border">{{ GetEmployeeFunc::CategoryName($month_kintai->employee_category_id) }}</td>
                            <td class="p-1 px-2 border text-right">{{ $month_kintai->total_working_time == null ? number_format(0, 2) : number_format($month_kintai->total_working_time / 60, 2) }}</td>
                            <td class="p-1 px-2 border text-right">{{ $month_kintai->total_over_time == null ? number_format(0, 2) : number_format($month_kintai->total_over_time / 60, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
