<script src="{{ asset('js/punch_finish_input.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/punch_finish_tab.css') }}">
<script src="{{ asset('js/punch_finish_tab.js') }}" defer></script>

<x-app-layout>
    <form method="post" id="punch_enter_form" action="{{ route('punch_finish.enter') }}" class="m-0">
        @csrf
        <div class="py-5 mx-5">
            <div class="grid grid-cols-12 gap-4">
                <a href="{{ route('punch_finish.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
                <p class="col-start-2 col-span-7 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">勤務情報入力</p>
                <p class="col-start-9 col-span-4 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">{{ \Carbon\Carbon::now()->isoFormat('YYYY年MM月DD日(ddd)') }}</p>
            </div>
            <div class="grid grid-cols-12">
                <!-- 概要情報を表示 -->
                <div class="col-span-12 grid grid-cols-12 text-4xl py-3 text-white bg-blue-500 rounded-t-lg">
                    <p class="col-start-1 col-span-4 pl-3">{{ $kintai->employee->employee_name }}<span class="text-xl ml-3">さん</span></p>
                    <p class="col-start-5 col-span-4 text-center">出勤 {{ substr($kintai->begin_time_adj, 0, 5) }}</p>
                    <p class="col-start-9 col-span-4 text-center">退勤 {{ substr($finish_time_adj, 0, 5) }}</p>
                </div>
                <div class="col-start-1 col-span-12 border-2 border-blue-500">
                    <div class="py-5 grid grid-cols-12">
                        <p class="col-span-1 text-xl text-center pt-1">外出(時)</p>
                        <p class="col-span-2 text-2xl text-left">{{ number_format($kintai->out_return_time / 60, 2) }}</p>
                        <p class="col-span-1 text-xl text-center pt-1">休憩(分)</p>
                        <input id="rest_time" name="rest_time" class="col-span-2 text-2xl text-left" readonly>
                        <p class="col-span-1 text-xl text-center pt-1">稼働(時)</p>
                        <input id="working_time" name="working_time" class="col-span-2 text-2xl text-left" readonly>
                        <input type="hidden" id="org_rest_time" value="{{ $rest_time }}">
                        <input type="hidden" id="org_working_time" value="{{ $working_time }}">
                        <input type="hidden" name="finish_time_adj" value="{{ $finish_time_adj }}">
                        <input type="hidden" name="kintai_id" value="{{ $kintai->kintai_id }}">
                        <input type="hidden" name="finish_time" value="{{ $finish_time }}">
                    </div>
                </div>
                <!-- 休憩未取得時間を表示 -->
                <p class="col-start-1 col-span-12 text-4xl py-3 pl-3 text-white bg-blue-500">休憩未取得時間</p>
                <div class="col-start-1 col-span-12 border-2 border-blue-500">
                    <div class="p-5 grid grid-cols-12 gap-4">
                        @foreach($no_rest_times as $no_rest_time)
                            <div class="col-span-2">
                                <input type="radio" name="no_rest_time" id="{{ $no_rest_time['minute'] }}" value="{{ $no_rest_time['minute'] }}" class="no_rest_time_select hidden" {{ $no_rest_time['minute'] == '0' ? 'checked' : '' }}>
                                <label id="{{ $no_rest_time['minute'].'_label' }}" for="{{ $no_rest_time['minute'] }}" class="cursor-pointer flex flex-col w-full max-w-lg mx-auto text-center border-2 rounded-lg border-gray-900 p-2 text-2xl">{{ $no_rest_time['text1'] }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- 追加休憩取得時間を表示 -->
                @if($add_rest_time_disp == 'on')
                    <p class="col-start-1 col-span-12 text-4xl py-3 pl-3 text-white bg-blue-500">追加休憩取得時間</p>
                    <div class="col-start-1 col-span-12 border-2 border-blue-500">
                        <div class="p-5 grid grid-cols-12 gap-4">
                            @foreach($add_rest_times as $add_rest_time)
                                <div class="col-span-2">
                                    <input type="radio" name="add_rest_time" id="{{ $add_rest_time['minute'].'_add_rest_time' }}" value="{{ $add_rest_time['minute'] }}" class="add_rest_time_select hidden" {{ $add_rest_time['minute'] == '0' ? 'checked' : '' }}>
                                    <label id="{{ $add_rest_time['minute'].'_add_rest_time_label' }}" for="{{ $add_rest_time['minute'].'_add_rest_time' }}" class="cursor-pointer flex flex-col w-full max-w-lg mx-auto text-center border-2 rounded-lg border-gray-900 p-2 text-2xl">{{ $add_rest_time['text1'] }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <!-- 入力した荷主稼働時間情報を表示 -->
                <div class="col-span-12 grid grid-cols-12 text-4xl py-3 text-white bg-blue-500">
                    <p class="col-span-4 pl-3">荷主稼働時間</p>
                    <p class="col-start-8 col-span-5 text-right pr-3">残り入力時間：<span id="input_time_left"></span></p>
                </div>
                <div class="col-start-1 col-span-12 border-2 border-blue-500 rounded-b-lg grid grid-cols-12">
                    <div id="input_working_time_info" class="p-5 col-span-12 grid grid-cols-12 gap-4"></div>
                </div>
            </div>
            <!-- 荷主情報のタブを表示 -->
            <x-customer-tab :customers="$customers" :customergroups="$customer_groups" :supportbases="$support_bases"></x-customer-tab>
            <button type="button" id="punch_finish_enter" class="punch_enter w-full text-center bg-blue-200 py-8 text-4xl rounded-lg mt-3">入力完了</button>
        </div>
    </form>
    <!-- 時間入力モーダル -->
    <x-working_time_input_modal/>
    <!-- 打刻確認モーダル -->
    <x-punch-confirm-modal-2 :employee="$kintai->employee->employee_name" message="退勤処理を行いますか？" enterbtntext="退勤"/>
</x-app-layout>
