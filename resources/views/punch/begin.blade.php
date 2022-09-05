<script src="{{ asset('js/clock.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/clock.css') }}">
<script src="{{ asset('js/punch_begin.js') }}" defer></script>

<x-app-layout>
    <x-loading></x-loading>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12">
            <a href="{{ route('punch.menu') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-sky-200 mb-5 hover:bg-sky-500 hover:text-white">戻る</a>
            <p class="col-start-1 col-span-12 text-4xl py-3 text-center text-white bg-blue-500 rounded-t-lg">出勤画面</p>
            <!-- 時計を表示 -->
            <div class="col-start-1 col-span-12 clock_container border-2 border-blue-500 rounded-b-lg">
                <div class="clock" style="font-family:'Share Tech Mono'">
                    <p class="clock-date"></p>
                    <p class="clock-time"></p>
                </div>
            </div>
        </div>
        <form method="post" id="punch_begin_confirm_form" action="{{ route('punch_begin.confirm') }}" class="m-0">
            @csrf
            <!-- 従業員名ボタンを表示 -->
            <div class="grid grid-cols-12 gap-4 mt-10">
                @foreach($employees as $employee)
                    <button type="submit" name="employee_no" class="punch_begin_confirm col-span-3 bg-black text-white text-center text-2xl rounded-lg px-8 py-10 hover:bg-sky-500" value="{{ $employee->employee_no }}">{{ $employee->employee_name }}</button>
                @endforeach
            </div>
        </form>
    </div>
</x-app-layout>
