<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('punch.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-4 col-span-6 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">今月の勤怠</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <div class="col-span-12 grid grid-cols-12 gap-4 mt-5">
                @foreach($month_kintais as $month_kintai)
                    <a href="{{ route('this_month_kintai.detail', ['employee_no' => $month_kintai->employee_no]) }}" class="col-span-3 grid grid-cols-12 rounded-lg px-8 py-4 bg-blue-200 text-xl">
                        <p class="col-span-12 text-center text-3xl">{{ $month_kintai->employee_name }}</p>
                        <div class="col-span-12 grid grid-cols-12 border-b-2 border-blue-500 mb-3">
                            <p class="col-span-4 text-left">稼働</p>
                            <p class="col-span-8 text-right">{{ number_format($month_kintai->total_working_time / 60, 2).' 時間' }}</p>
                        </div>
                        <div class="col-span-12 grid grid-cols-12 border-b-2 border-blue-500">
                            <p class="col-span-4 text-left">残業</p>
                            <p class="col-span-8 text-right">{{ number_format($month_kintai->total_over_time / 60, 2).' 時間' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
