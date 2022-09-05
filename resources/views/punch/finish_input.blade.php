<script src="{{ asset('js/punch_finish_input.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/punch_finish_tab.css') }}">
<script src="{{ asset('js/punch_finish_tab.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12">
            <a href="{{ route('punch.menu') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-sky-200 mb-5 hover:bg-sky-500 hover:text-white">戻る</a>
            <p class="col-start-1 col-span-12 text-4xl py-3 text-center text-white bg-blue-500 rounded-t-lg">勤務情報入力画面</p>
            <!-- 情報を表示 -->
            <div class="col-start-1 col-span-12 border-2 border-blue-500 rounded-b-lg">
                <div class="py-5 grid grid-cols-12">
                    <p class="col-span-1 text-blue-500 text-xl text-center pt-1"><i class="las la-grin-alt la-lg"></i>従業員名</p>
                    <p class="col-span-3 text-blue-500 text-2xl text-left">{{ $employee->employee_name }}</p>
                    <p class="col-span-1 text-blue-500 text-xl text-center pt-1"><i class="las la-clock la-lg"></i>退勤時間</p>
                    <p class="col-span-3 text-blue-500 text-2xl text-left">{{ $finish_time }}</p>
                    <p class="col-span-1 text-blue-500 text-xl text-center pt-1"><i class="las la-business-time la-lg"></i>勤務時間</p>
                    <p class="col-span-3 text-blue-500 text-2xl text-left">{{ $working_time / 60 }}</p>
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
            <!-- モーダルボディ -->
            <div class="p-10">
                <div class="grid grid-cols-12">
                    <!-- 入力対象の荷主情報 -->
                    <p id="input_customer_name" class="col-span-4 mb-5 text-2xl"></p>
                    <p id="input_working_time" class="col-start-5 col-span-2 mb-5 text-3xl text-center" style="font-family:'Share Tech Mono'">0.00</p>
                    <input type="hidden" id="input_customer_id" name="input_customer_id">
                    <!-- 時間入力ボタン -->
                    <div class="col-start-1 col-span-4 grid grid-cols-12" style="font-family:'Share Tech Mono'">
                        <p class="col-span-11 bg-blue-500 text-2xl text-center py-5 rounded-lg text-white" style="font-family:Zen Maru Gothic">時間</p>
                        <button id="num_7" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">7<button>
                        <button id="num_8" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">8<button>
                        <button id="num_9" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">9<button>
                        <button id="num_4" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">4<button>
                        <button id="num_5" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">5<button>
                        <button id="num_6" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">6<button>
                        <button id="num_1" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">1<button>
                        <button id="num_2" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">2<button>
                        <button id="num_3" class="input_time col-span-3 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">3<button>
                        <button id="num_0" class="input_time col-span-11 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">0<button>
                    </div>
                    <!-- 分入力ボタン -->
                    <div class="col-start-5 col-span-4 grid grid-cols-12" style="font-family:'Share Tech Mono'">
                        <p class="col-start-2 col-span-4 bg-blue-500 text-2xl text-center py-5 rounded-lg text-white" style="font-family:Zen Maru Gothic">分</p>
                        <button id="num_0.25" class="input_time col-start-2 col-span-4 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">0.25<button>
                        <button id="num_0.50" class="input_time col-start-2 col-span-4 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">0.50<button>
                        <button id="num_0.75" class="input_time col-start-2 col-span-4 bg-blue-100 text-2xl text-center py-5 rounded-lg mt-3">0.75<button>
                        <button id="input_working_time_clear" class="col-start-2 col-span-4 bg-red-500 text-white text-2xl text-center py-5 rounded-lg mt-3">クリア<button>
                    </div>
                </div>
            </div>
            <!-- モーダルフッター -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-1">
                <a class="working_time_input_modal_close cursor-pointer rounded-lg text-white bg-red-400 hover:bg-sky-500 text-center p-4 col-span-1">
                    キャンセル
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
