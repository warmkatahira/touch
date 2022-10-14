<script src="{{ asset('js/punch_finish.js') }}" defer></script>

<x-app-layout>
    <x-loading></x-loading>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('punch.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white hover:bg-sky-500 mb-5">戻る</a>
            <p id="page_title" class="col-start-2 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">退勤</p>
            <x-clock/>
        </div>
        <form method="get" id="punch_begin_confirm_form" action="{{ route('punch_finish.input') }}" class="m-0">
            <!-- 従業員名ボタンを表示 -->
            <div class="grid grid-cols-12 gap-4 mt-10">
                @foreach($employees as $employee)
                    <button type="submit" name="employee_no" class="col-span-3 bg-black text-white hover:bg-sky-500 text-center text-3xl rounded-lg px-8 py-10" value="{{ $employee->employee_no }}">{{ $employee->employee_name }}</button>
                @endforeach
            </div>
        </form>
    </div>
</x-app-layout>
