<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_1') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-2 col-span-4 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">荷主稼働詳細</p>
        </div>
        <!-- 荷主情報 -->
        <div class="grid grid-cols-12">
            <p class="col-span-12 text-2xl mb-4 border-l-4 border-blue-500 pl-2">荷主情報</p>
            <label class="col-start-1 col-span-1 bg-black text-white py-2 text-center">拠点</label>
            <p class="col-span-2 border border-black px-2 pt-2">{{ $customer->base->base_name }}</p>
            <label class="col-span-1 bg-black text-white py-2 text-center">荷主名</label>
            <p class="col-span-4 border border-black px-2 pt-2">{{ $customer->customer_name }}</p>
        </div>
        <!-- 荷主稼働時間情報 -->
        <div class="grid grid-cols-12 mt-5">
            <p class="col-span-12 text-2xl mb-4 border-l-4 border-blue-500 pl-2">{{ '荷主稼働時間情報≪'.\Carbon\Carbon::parse(session('search_month'))->isoFormat('YYYY年MM月').'≫' }}</p>
            <label class="col-start-1 col-span-1 bg-black text-white py-2 text-center">合計</label>
            <p class="col-span-1 border border-black px-2 pt-2 text-right">{{ number_format($customer->total_customer_working_time_total / 60, 2). ' 時間' }}</p>
            <label class="col-span-1 bg-black text-white py-2 text-center">正社員</label>
            <p class="col-span-2 border border-black px-2 pt-2 text-right">{{ number_format($customer->total_customer_working_time_syain / 60, 2). ' 時間（'.(is_null($customer->total_customer_working_time_total) ? '0.00' : number_format((($customer->total_customer_working_time_syain / $customer->total_customer_working_time_total) * 100),2)).' %）' }}</p>
            <label class="col-span-1 bg-black text-white py-2 text-center">パート</label>
            <p class="col-span-2 border border-black px-2 pt-2 text-right">{{ number_format($customer->total_customer_working_time_part / 60, 2). ' 時間（'.(is_null($customer->total_customer_working_time_total) ? '0.00' : number_format((($customer->total_customer_working_time_part / $customer->total_customer_working_time_total) * 100),2)).' %）' }}</p>
        </div>
        <!-- 稼働従業員一覧 -->
        <div class="grid grid-cols-12 mt-5">
            <table class="col-span-5 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-2/12">区分</th>
                        <th class="font-thin p-2 px-2 w-2/12">番号</th>
                        <th class="font-thin p-2 px-2 w-5/12">氏名</th>
                        <th class="font-thin p-2 px-2 w-3/12 text-right">荷主稼働時間</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($employees as $employee)
                        <tr class="hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $employee->employee_category->employee_category_name }}</td>
                            <td class="p-1 px-2 border">{{ $employee->employee_no }}</td>
                            <td class="p-1 px-2 border">{{ $employee->employee_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($employee->total_customer_working_time / 60, 2).' 時間' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
