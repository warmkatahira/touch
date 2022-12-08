<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_2') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-2 col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">勤怠修正<i class="las la-caret-right"></i>時間入力</p>
        </div>
        <!-- アラート表示 -->
        <x-alert/>
        <div class="grid grid-cols-12">
            <form method="GET" action="{{ route('punch_modify.input') }}" class="m-0 col-span-12 grid grid-cols-12">
                <!-- 修正の場合は早出か通常か決まっているので、初期値を現状に合わせる -->
                <?php $default = $kintai->is_early_worked == 1 ? "早出" : "通常" ?>
                <x-punch-begin-type :default="$default"/>
                <label for="begin_time" class="col-span-1 bg-black text-white text-center text-sm py-2 mt-3">出勤時間</label>
                <input type="time" id="begin_time" name="begin_time" class="col-span-1 text-sm mt-3" autocomplete="off" value="{{ old('begin_time', $kintai->begin_time) }}">
                <label for="finish_time" class="col-span-1 bg-black text-white text-center text-sm py-2 mt-3">退勤時間</label>
                <input type="time" id="finish_time" name="finish_time" class="col-span-1 text-sm mt-3" autocomplete="off" value="{{ old('finish_time', $kintai->finish_time) }}">
                <label for="out_time" class="col-start-1 col-span-1 bg-black text-white text-center text-sm py-2 mt-1">外出時間</label>
                <input type="time" id="out_time" name="out_time" class="col-span-1 text-sm mt-1" autocomplete="off" value="{{ old('out_time', $kintai->out_time) }}">
                <label for="return_time" class="col-span-1 bg-black text-white text-center text-sm py-2 mt-1">戻り時間</label>
                <input type="time" id="return_time" name="return_time" class="col-span-1 text-sm mt-1" autocomplete="off" value="{{ old('return_time', $kintai->return_time) }}">
                <button type="submit" class="col-start-1 col-span-4 bg-blue-200 text-center rounded-lg mt-5 py-3">次へ</button>
                <input type="hidden" name="kintai_id" value="{{ $kintai->kintai_id }}">
            </form>
        </div>
    </div>
</x-app-layout>
