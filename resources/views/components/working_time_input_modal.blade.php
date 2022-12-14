<!-- モーダル -->
<div id="working_time_input_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full">
    <div class="relative mx-auto shadow-lg rounded-md bg-white">
        <!-- モーダルヘッダー -->
        <div class="flex justify-between items-center bg-black text-white text-xl rounded-t-md px-4 py-2">
            <h4>荷主稼働時間入力</h4>
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
            <a id="working_time_input_enter" class="cursor-pointer rounded-lg text-white bg-blue-500 text-center p-4 col-span-5 text-3xl">
                入力
            </a>
            <a class="working_time_input_modal_close cursor-pointer rounded-lg text-white bg-red-400 text-center p-4 col-start-8 col-span-5 text-3xl">
                キャンセル
            </a>
        </div>
    </div>
</div>