<script src="{{ asset('js/punch_menu.js') }}" defer></script>
<x-app-layout>
    <!-- Alert -->
    <x-alert/>
    <!-- 打刻完了時のポップアップ表示 -->
    <x-punch_complete_popup/>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-x-4 gap-y-20">
            <a href="{{ route('punch_begin.index') }}" class="col-span-3 h-40 bg-black text-white text-6xl text-center font-semibold rounded-lg shadow-lg py-12">出勤</a>
            <a href="{{ route('punch_finish.index') }}" class="col-span-3 h-40 bg-black text-white text-6xl text-center font-semibold rounded-lg shadow-lg py-12">退勤</a>
            <a href="{{ route('punch_out.index') }}" class="col-span-3 h-40 bg-black text-white text-6xl text-center font-semibold rounded-lg shadow-lg py-12">外出</a>
            <a href="{{ route('punch_return.index') }}" class="col-span-3 h-40 bg-black text-white text-6xl text-center font-semibold rounded-lg shadow-lg py-12">戻り</a>
            <a href="{{ route('today_kintai.index') }}" class="col-span-3 h-40 bg-black text-white text-5xl 2xl:text-6xl text-center font-semibold rounded-lg shadow-lg py-14 2xl:py-12">今日の勤怠</a>
            <a href="{{ route('this_month_kintai.index') }}" class="col-span-3 h-40 bg-black text-white text-5xl 2xl:text-6xl text-center font-semibold rounded-lg shadow-lg py-14 2xl:py-12">今月の勤怠</a>
        </div>
    </div>
</x-app-layout>
