<script src="{{ asset('js/kintai_detail.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_1') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p id="page_title" class="col-start-2 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">勤怠詳細</p>
            <a href="{{ route('kintai.delete', ['kintai_id' => $kintai->kintai_id]) }}" id="kintai_delete" class="col-start-11 col-span-1 text-xl py-4 rounded-lg text-center bg-red-500 mb-5 text-white">削除</a>
            <a href="{{ route('punch_modify.index', ['kintai_id' => $kintai->kintai_id]) }}" class="col-start-12 col-span-1 text-xl py-4 rounded-lg text-center bg-blue-200 mb-5">修正</a>
        </div>
        <div class="grid grid-cols-12">
            <p class="col-span-12 text-2xl mb-4 border-l-4 border-blue-500 pl-2">勤怠概要</p>
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm">出勤日</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center">{{ $kintai->work_day }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm">拠点</p>
            <p class="col-span-2 border border-black text-sm py-2 text-center">{{ $kintai->employee->base->base_name }}</p>
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">氏名</p>
            <p class="col-span-2 border border-black text-sm py-2 text-center mt-1">{{ $kintai->employee->employee_name }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">区分</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ $kintai->employee->employee_category->employee_category_name }}</p>
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">出勤区分</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ $kintai->is_early_worked == 0 ? '通常' : '早出' }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">出勤時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ substr($kintai->begin_time_adj, 0, 5) }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">退勤時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ substr($kintai->finish_time_adj, 0, 5) }}</p>
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">外出時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ substr($kintai->out_time_adj, 0, 5) }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">戻り時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ substr($kintai->return_time_adj, 0, 5) }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">外出戻り時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ $kintai->out_return_time == null ? '' : number_format($kintai->out_return_time / 60, 2) }}</p>
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">休憩取得時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ is_null($kintai->rest_time) ? '' : number_format($kintai->rest_time / 60, 2) }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">休憩未取得時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ is_null($kintai->no_rest_time) ? '' : number_format($kintai->no_rest_time / 60, 2) }}</p>
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">稼働時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ is_null($kintai->working_time) ? '' : number_format($kintai->working_time / 60, 2) }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">残業時間</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ is_null($kintai->over_time) ? '' : number_format($kintai->over_time /60, 2) }}</p>
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm mt-1">手動打刻</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ $kintai->is_manual_punched == 1 ? '○' : '' }}</p>
            <p class="col-span-1 bg-black text-white text-center py-2 text-sm mt-1">修正</p>
            <p class="col-span-1 border border-black text-sm py-2 text-center mt-1">{{ $kintai->is_modified == 1 ? '○' : '' }}</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <p class="col-span-12 text-2xl border-l-4 border-blue-500 pl-2">荷主稼働時間</p>
            @foreach($kintai_details as $kintai_detail)
                <div class="col-span-3 bg-blue-100 py-5 rounded-lg text-center">
                    <p class="">{{ number_format($kintai_detail->customer_working_time / 60, 2) }}</p>
                    <p class="">{{ $kintai_detail->customer->customer_name }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
