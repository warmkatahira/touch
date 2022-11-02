<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-span-12 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">手動打刻<i class="las la-caret-right"></i>時間入力</p>
        </div>
        <div class="grid grid-cols-12">
            <form method="GET" action="{{ route('punch_manual.input') }}" class="m-0 col-span-12 grid grid-cols-12">
                <x-punch-begin-type default="通常"/>
                <label for="work_day" class="col-span-1 bg-black text-white text-center text-sm py-2 mt-3">出勤日</label>
                <input type="date" id="work_day" name="work_day" class="col-span-1 text-sm mt-3" autocomplete="off" value="{{ old('work_day') }}">
                <label for="employee" class="col-start-1 col-span-1 bg-black text-white text-center text-sm py-2 mt-1">従業員</label>
                <select id="employee" name="employee" class="col-span-2 text-sm mt-1">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->employee_no }}" {{ $employee->employee_no == old('employee') ? 'selected' : '' }}>{{ $employee->employee_name }}</option>
                    @endforeach
                </select>
                <label for="begin_time" class="col-start-1 col-span-1 bg-black text-white text-center text-sm py-2 mt-1">出勤時間</label>
                <input type="time" id="begin_time" name="begin_time" class="col-span-1 text-sm mt-1" autocomplete="off" value="{{ old('begin_time') }}">
                <label for="finish_time" class="col-span-1 bg-black text-white text-center text-sm py-2 mt-1">退勤時間</label>
                <input type="time" id="finish_time" name="finish_time" class="col-span-1 text-sm mt-1" autocomplete="off" value="{{ old('finish_time') }}">
                <label for="out_time" class="col-start-1 col-span-1 bg-black text-white text-center text-sm py-2 mt-1">外出時間</label>
                <input type="time" id="out_time" name="out_time" class="col-span-1 text-sm mt-1" autocomplete="off" value="{{ old('out_time') }}">
                <label for="return_time" class="col-span-1 bg-black text-white text-center text-sm py-2 mt-1">戻り時間</label>
                <input type="time" id="return_time" name="return_time" class="col-span-1 text-sm mt-1" autocomplete="off" value="{{ old('return_time') }}">
                <button type="submit" class="col-start-1 col-span-4 bg-blue-200 text-center rounded-lg mt-5 py-3">次へ</button>
            </form>
        </div>
    </div>
</x-app-layout>
