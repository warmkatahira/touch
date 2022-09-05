<script src="{{ asset('js/clock.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/clock.css') }}">
<script src="{{ asset('js/punch_begin.js') }}" defer></script>

<x-app-layout>
    <x-loading></x-loading>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12">
            <a href="{{ route('punch.menu') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-sky-200">戻る</a>
            <p class="col-start-4 col-span-6 text-4xl py-3 text-center text-blue-500">出勤画面</p>
            <div class="col-start-4 col-span-6 clock_container">
                <div class="clock" style="font-family:'Share Tech Mono'">
                    <p class="clock-date"></p>
                    <p class="clock-time"></p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-10">
            @foreach($employees as $employee)
                <button id="{{ $employee->employee_no }}" class="punch_begin_confirm_modal_open col-span-3 bg-black text-white text-center text-2xl rounded-lg px-8 py-10 hover:bg-sky-500">{{ $employee->employee_name }}</button>
            @endforeach
        </div>
    </div>
    <!-- モーダル -->
    <div id="punch_begin_confirm_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full">
        <div class="relative mx-auto shadow-lg rounded-md bg-white">
            <!-- モーダルヘッダー -->
            <div class="flex justify-between items-center bg-black text-white text-xl rounded-t-md px-4 py-2">
                <h4>出勤打刻画面</h4>
                <button class="punch_begin_confirm_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- モーダルボディ -->
            <div class="p-10">
                <form method="post" id="punch_begin_confirm_form" action="{{ route('punch_begin.confirm') }}" class="m-0">
                    @csrf
                    <!-- 日付と時間 -->
                    <div class="grid grid-cols-2 text-5xl mb-5" style="font-family:'Share Tech Mono'">
                        <p class="col-span-1 text-xl text-center font-bold">日付</p>
                        <p class="col-span-1 text-xl text-center font-bold">時間</p>
                        <input name="clock_date" id="clock_date" class="text-center col-span-1" readonly>
                        <input name="clock_time" id="clock_time" class="text-center col-span-1" readonly>
                    </div>
                    <p id="employee_name" class="text-center text-5xl mb-10"></p>
                    <input type="hidden" name="employee_no" id="employee_no">
                    <ul class="tab">
                        <li class="tab_menu active">全て</li>
                        @foreach($customer_groups as $customer_group)
                            <li class="tab_menu">{{ $customer_group->customer_group_name }}</li>
                        @endforeach
                    </ul>
                    <ul class="tab_detail_wrap show">
                        <div class="grid grid-cols-12 gap-4 mt-5">
                            @foreach($customers as $customer)
                                <button type="submit" name="customer_id" class="customer_select col-span-4 text-center text-white bg-black hover:bg-sky-500 rounded-lg py-4 px-2" value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</button>
                            @endforeach
                        </div>
                    </ul>
                    @foreach($customer_groups as $customer_group)
                        <ul class="tab_detail_wrap">
                            <div class="grid grid-cols-12 gap-4 mt-5">
                                @foreach($customer_group->customers as $customer)
                                    <button type="submit" name="customer_id" class="customer_select col-span-4 text-center text-white bg-black hover:bg-sky-500 rounded-lg py-4 px-2" value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</button>
                                @endforeach
                            </div>
                        </ul>
                    @endforeach
                </form>
            </div>
            <!-- モーダルフッター -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-1">
                <a class="punch_begin_confirm_modal_close cursor-pointer rounded-lg text-white bg-red-400 hover:bg-sky-500 text-center p-4 col-span-1">
                    キャンセル
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
