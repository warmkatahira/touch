<script src="{{ asset('js/punch_begin.js') }}" defer></script>

<x-app-layout>
    <x-loading></x-loading>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('punch.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white hover:bg-sky-500 mb-5">戻る</a>
            <p class="col-start-2 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">出勤画面</p>
            <x-clock/>
        </div>
        <form method="post" id="punch_begin_enter_form" action="{{ route('punch_begin.enter') }}" class="m-0">
            @csrf
            <div class="grid grid-cols-12 gap-4 mt-5">
                <!-- 現在の時刻によってボタンの表示/非表示を可変 -->
                @if($punch_begin_type_enabled == 'on')
                    <div class="col-span-12 grid grid-cols-12">
                        <input type="checkbox" id="punch_begin_type" name="punch_begin_type" class="peer hidden">
                        <label for="punch_begin_type" id="punch_begin_type_label" class="bg-gray-200 select-none cursor-pointer rounded-lg border-2 border-black py-8 px-6 transition-colors duration-200 ease-in-out peer-checked:bg-blue-200 col-span-2 text-center text-3xl">通常</label>
                    </div>
                @endif
                <!-- 従業員名ボタンを表示 -->
                <div class="col-span-12 grid grid-cols-12 gap-4 mt-5">
                    @foreach($employees as $employee)
                        <button type="submit" name="employee_no" class="punch_begin_enter col-span-3 bg-black text-white hover:bg-sky-500 text-center text-3xl rounded-lg px-8 py-10" value="{{ $employee->employee_no }}">{{ $employee->employee_name }}</button>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
