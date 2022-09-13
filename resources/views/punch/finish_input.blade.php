<script src="{{ asset('js/punch_finish_input.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/punch_finish_tab.css') }}">
<script src="{{ asset('js/punch_finish_tab.js') }}" defer></script>
<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12">
            <a href="{{ route('punch_finish.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-sky-200 mb-5 hover:bg-sky-500 hover:text-white">戻る</a>
            <p class="col-start-4 col-span-6 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">勤務情報入力画面</p>
            <!-- 概要情報を表示 -->
            <p class="col-start-1 col-span-12 text-4xl py-3 text-center text-white bg-blue-500 rounded-t-lg">{{ $employee->employee_name }}<span class="text-xl ml-3">さん</span></p>
            <div class="col-start-1 col-span-12 border-2 border-blue-500">
                <div class="py-5 grid grid-cols-12">
                    <p class="col-span-1 text-blue-500 text-xl text-center pt-1"><i class="las la-clock la-lg"></i>出勤時間</p>
                    <p class="col-span-2 text-blue-500 text-2xl text-left">{{ $kintai->begin_time_adj }}</p>
                    <p class="col-span-1 text-blue-500 text-xl text-center pt-1"><i class="las la-clock la-lg"></i>退勤時間</p>
                    <p class="col-span-2 text-blue-500 text-2xl text-left">{{ $finish_time }}</p>
                    <p class="col-span-1 text-blue-500 text-xl text-center pt-1"><i class="las la-business-time la-lg"></i>勤務時間</p>
                    <p class="col-span-2 text-blue-500 text-2xl text-left">{{ number_format($working_time / 60, 2) }}</p>
                    <p class="col-span-1 text-blue-500 text-xl text-center pt-1"><i class="las la-utensils la-lg"></i></i>休憩時間</p>
                    <p class="col-span-2 text-blue-500 text-2xl text-left">{{ $rest_time }}</p>
                </div>
            </div>
            <!-- 休憩未取得時間を表示 -->
            <p class="col-start-1 col-span-12 text-4xl py-3 text-center text-white bg-blue-500">休憩未取得時間</p>
            <div class="col-start-1 col-span-12 border-2 border-blue-500">
                <div class="p-5 grid grid-cols-12 gap-4">
                    @foreach($no_rest_times as $no_rest_time)
                        <div class="col-span-2">
                            <input type="radio" name="no_rest_time" id="{{ $no_rest_time['minute'] }}" value="{{ $no_rest_time['minute'] }}" class="no_rest_time_select hidden" {{ $no_rest_time['minute'] == '0' ? 'checked' : '' }}>
                            <label id="{{ $no_rest_time['minute'].'_label' }}" for="{{ $no_rest_time['minute'] }}" class="cursor-pointer flex flex-col w-full max-w-lg mx-auto text-center border-2 rounded-lg border-gray-900 p-2 text-2xl hover:bg-gray-200">{{ $no_rest_time['text1'] }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- 入力した荷主稼働時間情報を表示 -->
            <p class="col-span-12 text-4xl py-3 text-center text-white bg-blue-500">荷主稼働時間</p>
            <div class="col-start-1 col-span-12 border-2 border-blue-500 rounded-b-lg grid grid-cols-12">
                <p class="col-start-2 col-span-10 text-right text-2xl mt-3">残り入力時間：<span id="input_time_left" class="text-2xl">{{ number_format($working_time / 60, 2) }}</span></p>
                <div id="input_working_time_info" class="p-5 col-span-12 grid grid-cols-12 gap-4">
                    
                </div>
            </div>
        </div>
        <!-- 荷主情報のタブを表示 -->
        <div class="mt-5 p-5 border-2 border-blue-500 rounded-lg bg-sky-100">
            <ul class="tab">
                <li class="tab_menu active">全て</li>
                @foreach($customer_groups as $customer_group)
                    <li class="tab_menu">{{ $customer_group->customer_group_name }}</li>
                @endforeach
            </ul>
            <ul class="tab_detail_wrap show">
                <div class="grid grid-cols-12 gap-4 mt-5">
                    @foreach($customers as $customer)
                        <button type="button" name="customer_id" class="working_time_input_modal_open col-span-4 text-center text-white bg-black hover:bg-sky-500 rounded-lg py-4 px-2" value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</button>
                    @endforeach
                </div>
            </ul>
            @foreach($customer_groups as $customer_group)
                <ul class="tab_detail_wrap">
                    <div class="grid grid-cols-12 gap-4 mt-5">
                        @foreach($customer_group->customers as $customer)
                            <button type="button" name="customer_id" class="working_time_input_modal_open col-span-4 text-center text-white bg-black hover:bg-sky-500 rounded-lg py-4 px-2" value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</button>
                        @endforeach
                    </div>
                </ul>
            @endforeach
        </div>
    </div>
    <!-- モーダル -->
    <div id="working_time_input_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full">
        <div class="relative mx-auto shadow-lg rounded-md bg-white">
            <!-- モーダルヘッダー -->
            <div class="flex justify-between items-center bg-black text-white text-xl rounded-t-md px-4 py-2">
                <h4>荷主稼働時間入力画面</h4>
                <button class="working_time_input_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- モーダルボディー -->
            <div class="p-10">
                <div class="grid grid-cols-12">
                    <!-- 入力情報 -->
                    <div class="col-start-1 col-span-6 grid grid-cols-12">
                        <p id="input_customer_name" class="col-span-12 text-4xl row-start-8"></p>
                        <div class="col-span-5 text-center">
                            <p class="text-2xl bg-black text-white py-3 rounded-t-lg">残り入力時間</p>
                            <p id="input_time_left_modal" class="text-5xl py-3 border-black border-x-2 border-b-2 rounded-b-lg" style="font-family:'Share Tech Mono'"></p>
                        </div>
                        <div class="col-start-7 col-span-5 text-center">
                            <p class="text-2xl bg-blue-500 text-white py-3 rounded-t-lg">入力稼働時間</p>
                            <p id="input_working_time" class="text-5xl py-3 border-blue-500 border-x-2 border-b-2 rounded-b-lg" style="font-family:'Share Tech Mono'"></p>
                        </div>
                        <input type="hidden" id="input_customer_id" name="input_customer_id" class="">
                    </div>
                    <!-- 時間入力ボタン -->
                    <div class="col-start-7 col-span-4 grid grid-cols-12" style="font-family:'Share Tech Mono'">
                        <p class="col-span-11 bg-blue-500 text-2xl text-center py-5 rounded-lg text-white" style="font-family:Zen Maru Gothic">時間入力</p>
                        <button id="num_7" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">7<button>
                        <button id="num_8" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">8<button>
                        <button id="num_9" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">9<button>
                        <button id="num_4" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">4<button>
                        <button id="num_5" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">5<button>
                        <button id="num_6" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">6<button>
                        <button id="num_1" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">1<button>
                        <button id="num_2" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">2<button>
                        <button id="num_3" class="input_time col-span-3 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">3<button>
                        <button id="all_input" class="col-span-11 bg-pink-200 text-2xl text-center py-5 rounded-lg mt-3">残り時間を全て入力<button>
                    </div>
                    <!-- 分入力ボタン -->
                    <div class="col-start-11 col-span-2 grid grid-cols-12" style="font-family:'Share Tech Mono'">
                        <p class="col-start-2 col-span-10 bg-blue-500 text-2xl text-center py-5 rounded-lg text-white" style="font-family:Zen Maru Gothic">分入力</p>
                        <button id="num_0.25" class="input_time col-start-2 col-span-10 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">0.25<button>
                        <button id="num_0.50" class="input_time col-start-2 col-span-10 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">0.50<button>
                        <button id="num_0.75" class="input_time col-start-2 col-span-10 bg-blue-100 text-4xl text-center py-5 rounded-lg mt-3">0.75<button>
                        <button id="input_working_time_clear" class="col-start-2 col-span-10 bg-red-500 text-white text-2xl text-center py-5 rounded-lg mt-3">クリア<button>
                    </div>
                </div>
            </div>
            <!-- モーダルフッター -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-12">
                <a id="working_time_input_enter" class="cursor-pointer rounded-lg text-white bg-blue-500 hover:bg-sky-500 text-center p-4 col-span-5">
                    入力
                </a>
                <a class="working_time_input_modal_close cursor-pointer rounded-lg text-white bg-red-400 hover:bg-sky-500 text-center p-4 col-start-8 col-span-5">
                    キャンセル
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
