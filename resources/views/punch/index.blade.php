<script src="{{ asset('js/punch_menu.js') }}" defer></script>
<x-app-layout>
    <!-- Alert -->
    <x-alert/>
    <!-- 打刻完了時のポップアップ表示 -->
    <x-punch_complete_popup/>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12">
            <a href="{{ route('punch_begin.index') }}" class="col-start-2 col-span-4 h-40 bg-black text-white hover:bg-sky-500 text-6xl text-center font-semibold rounded-lg shadow-lg py-12">出勤</a>
            <a href="{{ route('punch_finish.index') }}" class="col-start-8 col-span-4 h-40 bg-black text-white hover:bg-sky-500 text-6xl text-center font-semibold rounded-lg shadow-lg py-12">退勤</a>
            <a href="{{ route('punch_out.index') }}" class="col-start-2 col-span-4 h-40 bg-black text-white hover:bg-sky-500 text-6xl text-center font-semibold rounded-lg shadow-lg py-12 mt-20">外出</a>
            <a href="{{ route('punch_return.index') }}" class="col-start-8 col-span-4 h-40 bg-black text-white hover:bg-sky-500 text-6xl text-center font-semibold rounded-lg shadow-lg py-12 mt-20">戻り</a>
            <a href="{{ route('today_kintai.index') }}" class="col-start-2 col-span-4 h-40 bg-black text-white hover:bg-sky-500 text-6xl text-center font-semibold rounded-lg shadow-lg py-12 mt-20">今日の勤怠</a>
            <a href="{{ route('this_month_kintai.index') }}" class="col-start-8 col-span-4 h-40 bg-black text-white hover:bg-sky-500 text-6xl text-center font-semibold rounded-lg shadow-lg py-12 mt-20">今月の勤怠</a>
        </div>
    </div>
</x-app-layout>
