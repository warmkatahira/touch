<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('punch.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p id="page_title" class="col-start-2 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">勤怠一覧</p>
        </div>
        <div class="grid grid-cols-12 my-2 border border-black p-5 rounded-lg bg-sky-100">
            <p class="col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2">検索条件</p>
            <form method="GET" action="{{ route('kintai_list.search') }}" class="m-0 col-span-12 grid grid-cols-12">
                <label for="search_employee_name" class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm">氏名</label>
                <input type="text" id="search_employee_name" name="search_employee_name" class="col-span-2 border border-black text-sm" value="{{ session('search_employee_name') }}" autocomplete="off">
                <label for="search_base" class="col-span-1 bg-black text-white text-center py-2 text-sm">営業所</label>
                <select id="search_base" name="search_base" class="col-span-2 border border-black text-sm">
                    <option value=""></option>
                    @foreach($bases as $base)
                        <option value="{{ $base->base_id }}" {{ $base->base_id == session('search_base') ? 'selected' : '' }}>{{ $base->base_name }}</option>
                    @endforeach
                </select>
                <label for="search_employee_category" class="col-span-1 bg-black text-white text-center py-2 text-sm">区分</label>
                <select id="search_employee_category" name="search_employee_category" class="col-span-2 border border-black text-sm">
                    <option value=""></option>
                    @foreach($employee_categories as $employee_category)
                        <option value="{{ $employee_category->employee_category_id }}" {{ $employee_category->employee_category_id == session('search_employee_category') ? 'selected' : '' }}>{{ $employee_category->employee_category_name }}</option>
                    @endforeach
                </select>
                <label for="search_work_day_from" class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">出勤日</label>
                <input type="date" id="search_work_day_from" name="search_work_day_from" class="col-span-2 border border-black text-sm mt-1" value="{{ session('search_work_day_from') }}" autocomplete="off">
                <label class="col-span-1 text-center text-sm py-2 mt-1">～</label>
                <input type="date" id="search_work_day_to" name="search_work_day_to" class="col-span-2 border border-black text-sm mt-1" value="{{ session('search_work_day_to') }}" autocomplete="off">
                <button type="submit" class="col-start-12 col-span-1 text-sm text-center bg-black text-white"><i class="las la-search la-lg"></i></button>
            </form>
        </div>
        <div class="grid grid-cols-12">
            <table class="col-span-12 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-1/12">出勤日</th>
                        <th class="font-thin p-2 px-2 w-2/12">氏名</th>
                        <th class="font-thin p-2 px-2 w-1/12">出勤時間</th>
                        <th class="font-thin p-2 px-2 w-1/12">退勤時間</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-right">稼働時間</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-right">残業時間</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($kintais as $kintai)
                        <tr class="hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $kintai->work_day }}</td>
                            <td class="p-1 px-2 border">{{ $kintai->employee_name }}</td>
                            <td class="p-1 px-2 border">{{ substr($kintai->begin_time_adj, 0, 5) }}</td>
                            <td class="p-1 px-2 border">{{ substr($kintai->finish_time_adj, 0, 5) }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($kintai->working_time / 60, 2) }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($kintai->over_time / 60, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
