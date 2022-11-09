<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-start-1 col-span-4 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">残業ランキング</p>
        </div>
        <div class="grid grid-cols-12">
            <!-- 抽出条件 -->
            <div class="col-span-12 grid grid-cols-12 mb-5">
                <form method="GET" action="{{ route('over_time_rank.search') }}" class="m-0 col-span-12 grid grid-cols-12">
                    <label for="search_month" class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm">対象年月</label>
                    <input type="month" id="search_month" name="search_month" class="col-span-2 border border-black text-sm" value="{{ session('search_month') }}">
                    <button type="submit" class="col-start-7 col-span-1 text-center bg-blue-200 rounded-lg"><i class="las la-search la-lg"></i></button>
                </form>
            </div>
            <!-- 残業ランキング -->
            <table class="col-span-7 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-1/12">Rank</th>
                        <th class="font-thin p-2 px-2 w-3/12">拠点</th>
                        <th class="font-thin p-2 px-2 w-2/12">番号</th>
                        <th class="font-thin p-2 px-2 w-3/12">氏名</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">総残業時間</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($employees as $key => $employee)
                        <tr class="hover:bg-teal-100" data-href="{{ route('employee_list.detail', ['employee_no' => $employee->employee_no]) }}">
                            <td class="p-1 px-2 border">{{ $employee->total_over_time == 0 ? '-' : sprintf('%02d', $key + 1) }}</td>
                            <td class="p-1 px-2 border">{{ $employee->base->base_name }}</td>
                            <td class="p-1 px-2 border">{{ $employee->employee_no }}</td>
                            <td class="p-1 px-2 border">{{ $employee->employee_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ (number_format($employee->total_over_time / 60, 2)).' 時間' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
