<div class="col-span-12 grid grid-cols-12 gap-4 mt-10">
    <!-- 従業員名ボタンを表示 -->
    @foreach($employees as $employee)
        <button type="button" class="punch_enter col-span-3 bg-black text-white text-center text-3xl rounded-lg px-8 py-10" value="{{ $id == 'employee_no' ? $employee->employee_no : $employee->kintai_id }}">{{ $employee->employee_name }}</button>
    @endforeach
    <!-- 従業員番号送信用 -->
    <input type="hidden" id="punch_key" name="punch_key">
</div>