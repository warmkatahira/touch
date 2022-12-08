<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-start-1 col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">従業員一覧</p>
            <a href="{{ route('employee.register_index') }}" class="col-start-12 col-span-1 text-xl py-4 rounded-lg text-center bg-blue-200 mb-5">追加</a>
        </div>
        <!-- アラート表示 -->
        <x-alert/>
        <!-- 検索条件 -->
        <div class="grid grid-cols-12 my-2 border border-black p-5 rounded-lg bg-sky-100">
            <form method="GET" action="{{ route('employee_list.search') }}" class="m-0 col-span-12 grid grid-cols-12">
                <p class="col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2">検索条件</p>
                <!-- 条件クリアボタン -->
                <a href="{{ route('employee_list.index') }}" class="col-start-12 col-span-1 text-sm text-center bg-red-500 text-white py-1 rounded-lg"><i class="las la-trash-alt la-2x"></i></a>
                <!-- 拠点 -->
                <label for="search_base" class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">拠点</label>
                <select id="search_base" name="search_base" class="col-span-2 border border-black text-sm mt-1">
                    <option value=""></option>
                    @foreach($bases as $base_id => $base_name)
                        <option value="{{ $base_id }}" {{ $base_id == session('search_base') ? 'selected' : '' }}>{{ $base_name }}</option>
                    @endforeach
                </select>
                <!-- 区分 -->
                <label for="search_employee_category" class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">区分</label>
                <select id="search_employee_category" name="search_employee_category" class="col-span-1 border border-black text-sm mt-1">
                    <option value=""></option>
                    @foreach($employee_categories as $employee_category)
                        <option value="{{ $employee_category->employee_category_id }}" {{ $employee_category->employee_category_id == session('search_employee_category') ? 'selected' : '' }}>{{ $employee_category->employee_category_name }}</option>
                    @endforeach
                </select>
                <!-- 氏名 -->
                <label for="search_employee_name" class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">氏名</label>
                <input type="text" id="search_employee_name" name="search_employee_name" class="col-span-2 border border-black text-sm mt-1" value="{{ session('search_employee_name') }}" autocomplete="off" placeholder="部分一致で検索">
                <!-- 検索ボタン -->
                <button type="submit" class="col-start-12 col-span-1 text-sm text-center bg-black text-white rounded-lg mt-1"><i class="las la-search la-2x"></i></button>
            </form>
        </div>
        <!-- 勤怠一覧 -->
        <div class="grid grid-cols-12">
            <table class="col-span-12 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th class="font-thin p-2 px-2 w-2/12">拠点</th>
                        <th class="font-thin p-2 px-2 w-1/12">区分</th>
                        <th class="font-thin p-2 px-2 w-1/12">番号</th>
                        <th class="font-thin p-2 px-2 w-2/12">氏名</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">月間稼働設定</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">当月総稼働時間</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">当月総残業時間</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($employees as $employee)
                        <tr class="hover:bg-teal-100" data-href="{{ route('employee_list.detail', ['employee_no' => $employee->employee_no]) }}">
                            <td class="p-1 px-2 border">{{ $employee->base->base_name }}</td>
                            <td class="p-1 px-2 border">{{ $employee->employee_category->employee_category_name }}</td>
                            <td class="p-1 px-2 border">{{ $employee->employee_no }}</td>
                            <td class="p-1 px-2 border">{{ $employee->employee_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($employee->monthly_workable_time_setting, 2) }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($employee->total_working_time / 60, 2).' 時間' }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($employee->total_over_time / 60, 2).' 時間' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
