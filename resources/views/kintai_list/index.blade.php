<script src="{{ asset('js/kintai_list.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/radio_btn.css') }}">

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="{{ Auth::user()->role_id == 31 && Auth::user()->base_id == session('search_base') ? 'col-span-11' : 'col-span-12' }} text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 mb-5">勤怠一覧</p>
            <!-- 拠点管理者ロールであり自拠点の勤怠であればボタンを表示 -->
            @if(Auth::user()->role_id == 31 && Auth::user()->base_id == session('search_base'))
                <button type="button" id="manager_check_enter" class="col-span-1 bg-blue-100 border-2 border-blue-600 rounded-lg text-center text-sm px-2 h-3/4"><i class="las la-stamp la-2x text-blue-600"></i></button>
            @endif
        </div>
        <!-- アラート表示 -->
        <x-alert/>
        <!-- 検索条件 -->
        <div class="grid grid-cols-12 mb-2 border border-black p-5 rounded-lg bg-sky-100">
            <p class="col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2">検索条件</p>
            <form method="GET" action="{{ route('kintai_list.search') }}" class="m-0 col-span-12 grid grid-cols-12">
                <!-- 対象 -->
                <label class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm">対象</label>
                <div class="col-span-2 grid grid-cols-12 radiobox">
                    <input type="radio" id="all_target" class="radio_btn hidden" name="search_target" value="all_target" {{ session('search_target') == 'all_target' ? 'checked' : '' }}>
                    <label for="all_target" class="bg-gray-200 px-4 py-2 col-start-1 col-span-6 text-center border border-black text-sm">全て</label>
                    <input type="radio" id="no_finish" class="radio_btn hidden" name="search_target" value="no_finish" {{ session('search_target') == 'no_finish' ? 'checked' : '' }}>
                    <label for="no_finish" class="bg-gray-200 px-4 py-2 col-start-7 col-span-6 text-center border-y border-r border-black text-sm">未退勤のみ</label> 
                </div>
                <!-- 拠点管理者確認 -->
                <label class="col-span-1 bg-black text-white text-center py-2 text-sm">管理者確認</label>
                <div class="col-span-2 grid grid-cols-12 radiobox">
                    <input type="radio" id="all_manager_checked" class="radio_btn hidden" name="search_manager_checked" value="all_manager_checked" {{ session('search_manager_checked') == 'all_manager_checked' ? 'checked' : '' }}>
                    <label for="all_manager_checked" class="bg-gray-200 px-4 py-2 col-start-1 col-span-4 text-center border border-black text-sm">全て</label>
                    <input type="radio" id="unconfirmed" class="radio_btn hidden" name="search_manager_checked" value="unconfirmed" {{ session('search_manager_checked') == 'unconfirmed' ? 'checked' : '' }}>
                    <label for="unconfirmed" class="bg-gray-200 px-4 py-2 col-span-4 text-center border-y border-r border-black text-sm">未</label>
                    <input type="radio" id="confirmed" class="radio_btn hidden" name="search_manager_checked" value="confirmed" {{ session('search_manager_checked') == 'confirmed' ? 'checked' : '' }}>
                    <label for="confirmed" class="bg-gray-200 px-4 py-2 col-span-4 text-center border-y border-r border-black text-sm">済</label> 
                </div>
                <!-- タグ -->
                <label class="col-span-1 bg-black text-white text-center py-2 text-sm">タグ</label>
                <div class="col-span-2 grid grid-cols-12 radiobox">
                    <input type="radio" id="all_tag" class="radio_btn hidden" name="search_tag" value="all_tag" {{ session('search_tag') == 'all_tag' ? 'checked' : '' }}>
                    <label for="all_tag" class="bg-gray-200 px-4 py-2 col-start-1 col-span-4 text-center border border-black text-sm">全て</label>
                    <input type="radio" id="no_tag" class="radio_btn hidden" name="search_tag" value="no_tag" {{ session('search_tag') == 'no_tag' ? 'checked' : '' }}>
                    <label for="no_tag" class="bg-gray-200 px-4 py-2 col-span-4 text-center border-y border-r border-black text-sm">無</label>
                    <input type="radio" id="on_tag" class="radio_btn hidden" name="search_tag" value="on_tag" {{ session('search_tag') == 'on_tag' ? 'checked' : '' }}>
                    <label for="on_tag" class="bg-gray-200 px-4 py-2 col-span-4 text-center border-y border-r border-black text-sm">有</label> 
                </div>
                <!-- 条件クリアボタン -->
                <a href="{{ route('kintai_list.index') }}" class="col-start-12 col-span-1 text-sm text-center bg-red-500 text-white py-1 rounded-lg"><i class="las la-trash-alt la-2x"></i></a>
                <!-- 出勤日 -->
                <label for="search_work_day_from" class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">出勤日</label>
                <input type="date" id="search_work_day_from" name="search_work_day_from" class="col-span-2 border border-black text-sm mt-1" value="{{ session('search_work_day_from') }}" autocomplete="off">
                <label class="col-span-1 text-center text-sm py-2 mt-1">～</label>
                <input type="date" id="search_work_day_to" name="search_work_day_to" class="col-span-2 border border-black text-sm mt-1" value="{{ session('search_work_day_to') }}" autocomplete="off">
                <!-- 拠点 -->
                <label for="search_base" class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">拠点</label>
                <select id="search_base" name="search_base" class="col-span-2 border border-black text-sm mt-1">
                    @foreach($bases as $base_id => $base_name)
                        <option value="{{ $base_id }}" {{ $base_id == session('search_base') ? 'selected' : '' }}>{{ $base_name }}</option>
                    @endforeach
                </select>
                <!-- 区分 -->
                <label for="search_employee_category" class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">区分</label>
                <select id="search_employee_category" name="search_employee_category" class="col-span-2 border border-black text-sm mt-1">
                    <option value=""></option>
                    @foreach($employee_categories as $employee_category)
                        <option value="{{ $employee_category->employee_category_id }}" {{ $employee_category->employee_category_id == session('search_employee_category') ? 'selected' : '' }}>{{ $employee_category->employee_category_name }}</option>
                    @endforeach
                </select>
                <!-- 氏名 -->
                <label for="search_employee_name" class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">氏名</label>
                <input type="text" id="search_employee_name" name="search_employee_name" class="col-span-2 border border-black text-sm mt-1" value="{{ session('search_employee_name') }}" autocomplete="off" placeholder="部分一致で検索">
                <!-- 検索ボタン -->
                <button type="submit" class="col-start-12 col-span-1 text-sm text-center bg-black text-white mt-1 rounded-lg"><i class="las la-search la-2x"></i></button>
            </form>
        </div>
        <!-- 勤怠一覧 -->
        <div class="grid grid-cols-12">
            <table class="col-span-12 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th id="all_check" class="font-thin p-2 px-2 w-1/12 text-center"><i class="las la-check-square la-lg"></i></th>
                        <th class="font-thin p-2 px-2 w-2/12 text-center">出勤日</th>
                        <th class="font-thin p-2 px-2 w-2/12">氏名</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">出勤時間</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">退勤時間</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">稼働時間</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">残業時間</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">管理者タグ</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">経理タグ</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">管理者確認<i class="las la-stamp la-lg"></i></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <form method="post" action="{{ route('kintai_list.manager_check') }}" id="manager_check_form" class="m-0">
                        @csrf
                        @foreach($kintais as $kintai)
                            <tr id="all_check" class="hover:bg-teal-100">
                                <td class="p-1 px-2 border text-center">
                                    <!-- 退勤時間が埋まっている勤怠だけチェックボックスを表示 -->
                                    @if(!is_null($kintai->finish_time_adj))
                                        <input type="checkbox" name="chk[]" value="{{ $kintai->kintai_id }}">
                                    @endif
                                </td>
                                <td class="p-1 px-2 border text-center"><a href="{{ route('kintai_list.detail', ['kintai_id' => $kintai->kintai_id]) }}" class="text-blue-600 underline">{{ \Carbon\Carbon::parse($kintai->work_day)->isoFormat('YYYY年MM月DD日(ddd)') }}</a></td>
                                <td class="p-1 px-2 border">{{ $kintai->employee_name }}</td>
                                <td class="p-1 px-2 border text-center">{{ substr($kintai->begin_time_adj, 0, 5) }}</td>
                                <td class="p-1 px-2 border text-center">{{ substr($kintai->finish_time_adj, 0, 5) }}</td>
                                <td class="p-1 px-2 border text-center">{{ number_format($kintai->working_time / 60, 2) }}</td>
                                <td class="p-1 px-2 border text-center {{ $kintai->over_time == 0 ? '' : 'bg-pink-200' }}">{{ number_format($kintai->over_time / 60, 2) }}</td>
                                <td class="p-1 px-2 border text-center">{{ KintaiListFunc::TagCount($kintai->kintai_id, 31) }}</td>
                                <td class="p-1 px-2 border text-center">{{ KintaiListFunc::TagCount($kintai->kintai_id, 11) }}</td>
                                <td class="p-1 px-2 border text-center text-xs">{{ $kintai->manager_checked_at }}</td>
                            </tr>
                        @endforeach
                    </form>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
