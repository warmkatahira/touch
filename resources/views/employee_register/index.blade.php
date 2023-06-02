<script src="{{ asset('js/kintai_list.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_1') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">従業員追加</p>
        </div>
        <!-- アラート -->
        <x-alert/>
        <div class="grid grid-cols-12">
            <form method="POST" action="{{ route('employee.register') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <label for="base" class="col-start-1 col-span-2 bg-black text-white py-2 text-center">拠点</label>
                <select id="base" name="base" class="col-span-2">
                    @foreach($bases as $base_id => $base_name)
                        <option value="{{ $base_id }}" {{ $base_id == old('base') ? 'selected' : '' }}>{{ $base_name }}</option>
                    @endforeach
                </select>
                <label for="employee_category" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">従業員区分</label>
                <select id="employee_category" name="employee_category" class="col-span-2 mt-1">
                    @foreach($employee_categories as $employee_category)
                        <option value="{{ $employee_category->employee_category_id }}" {{ $employee_category->employee_category_id == old('employee_category') ? 'selected' : '' }}>{{ $employee_category->employee_category_name }}</option>
                    @endforeach
                </select>
                <label for="employee_no" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">従業員番号</label>
                <input type="text" id="employee_no" name="employee_no" class="col-span-2 mt-1" autocomplete="off" value="{{ old('employee_no') }}" placeholder="4桁で入力して下さい。">
                <label for="employee_name" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">従業員名</label>
                <input type="text" id="employee_name" name="employee_name" class="col-span-2 mt-1" autocomplete="off" value="{{ old('employee_name') }}">
                <label for="monthly_workable_time_setting" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">月間稼働設定</label>
                <input type="text" id="monthly_workable_time_setting" name="monthly_workable_time_setting" class="col-span-2 mt-1" autocomplete="off" value="{{ old('monthly_workable_time_setting', 0) }}">
                <label for="over_time_start_setting" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">残業開始時間設定</label>
                <input type="text" id="over_time_start_setting" name="over_time_start_setting" class="col-span-2 mt-1" autocomplete="off" value="{{ old('over_time_start_setting', 0) }}">
                <button class="col-start-1 col-span-4 py-4 rounded-lg text-center bg-blue-200 mt-5">追加</button>
            </form>
        </div>
    </div>
</x-app-layout>
