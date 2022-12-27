<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_2') }}" class="col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">従業員情報変更</p>
        </div>
        <div class="grid grid-cols-12">
            <form method="POST" action="{{ route('employee.modify') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <label for="base" class="col-start-1 col-span-2 bg-black text-white py-2 text-center">拠点</label>
                <select id="base" name="base" class="col-span-2">
                    @foreach($bases as $base_id => $base_name)
                        <option value="{{ $base_id }}" {{ $base_id == old('base', $employee->base_id) ? 'selected' : '' }}>{{ $base_name }}</option>
                    @endforeach
                </select>
                <label for="employee_category" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">従業員区分</label>
                <select id="employee_category" name="employee_category" class="col-span-2 mt-1">
                    @foreach($employee_categories as $employee_category)
                        <option value="{{ $employee_category->employee_category_id }}" {{ $employee_category->employee_category_id == old('employee_category', $employee->employee_category_id) ? 'selected' : '' }}>{{ $employee_category->employee_category_name }}</option>
                    @endforeach
                </select>
                <label for="employee_no" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">従業員番号</label>
                <input type="text" id="employee_no" name="employee_no" class="col-span-2 mt-1 bg-gray-200" autocomplete="off" value="{{ old('employee_no', $employee->employee_no) }}" readonly>
                <label for="employee_name" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">従業員名</label>
                <input type="text" id="employee_name" name="employee_name" class="col-span-2 mt-1" autocomplete="off" value="{{ old('employee_name', $employee->employee_name) }}">
                <label for="monthly_workable_time_setting" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">月間稼働設定</label>
                <input type="text" id="monthly_workable_time_setting" name="monthly_workable_time_setting" class="col-span-2 mt-1" autocomplete="off" value="{{ old('monthly_workable_time_setting', $employee->monthly_workable_time_setting) }}">
                <label for="over_time_start_setting" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">残業開始時間設定</label>
                <input type="text" id="over_time_start_setting" name="over_time_start_setting" class="col-span-2 mt-1" autocomplete="off" value="{{ old('over_time_start_setting', $employee->over_time_start_setting) }}">
                <!-- 経理ロール以上もしくは拠点管理者ロールであり自拠点の従業員であればボタンを表示 -->
                @if(Auth::user()->role_id <= 11 || Auth::user()->role_id == 31 && Auth::user()->base_id == $employee->base_id)
                    <button class="col-start-1 col-span-4 py-4 rounded-lg text-center bg-blue-200 mt-5">変更</button>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
