<script src="{{ asset('js/kintai_detail.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_1') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-2 col-span-9 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">勤怠詳細</p>
            <!-- 拠点管理者ロールであり自拠点の勤怠であればボタンを表示 -->
            @if(Auth::user()->role_id == 31 && Auth::user()->base_id == $kintai->employee->base_id)
                <a href="{{ route('kintai.delete', ['kintai_id' => $kintai->kintai_id]) }}" id="kintai_delete" class="col-start-11 col-span-1 text-xl py-4 rounded-lg text-center bg-red-500 mb-5 text-white">削除</a>
                <a href="{{ route('punch_modify.index', ['kintai_id' => $kintai->kintai_id]) }}" class="col-start-12 col-span-1 text-xl py-4 rounded-lg text-center bg-blue-200 mb-5">修正</a>
            @endif
        </div>
        <div class="grid grid-cols-12">
            <form method="POST" action="{{ route('kintai_tag.register') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <p class="col-span-1 text-2xl mb-4 border-l-4 border-blue-500 pl-2">タグ</p>
                <!-- 経理ロール又は拠点管理者ロールの場合は自拠点の勤怠であればタグ追加プルダウンを表示 -->
                @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 31 && Auth::user()->base_id == $kintai->employee->base_id)
                    <select name="tag" class="text-xs col-span-2 h-3/4">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->tag_id }}">{{ $tag->tag_name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="kintai_id" value="{{ $kintai->kintai_id }}">
                    <button type="submit" class="col-span-1 text-sm text-center bg-blue-600 text-white px-2 py-1 h-3/4">追加</button>
                @endif
            </form>
            <div class="col-start-1 col-span-6 grid grid-cols-12 gap-4">
                @foreach($kintai_tags as $kintai_tag)
                    <div class="flex justify-between px-4 py-2 col-span-3 text-sm {{ $kintai_tag->tag->owner_role_id == 11 ? 'text-red-600 border-red-600' : 'text-blue-600 border-blue-600' }} border-y-2 border-r-2 border-l-8">
                        {{ $kintai_tag->tag->tag_name }}
                        <!-- 自身が追加したタグのみ削除可能 -->
                        @if($kintai_tag->register_user_id == Auth::user()->id )
                            <a href="{{ route('kintai_tag.delete', ['kintai_tag_id' => $kintai_tag->kintai_tag_id]) }}" class="kintai_tag_delete mt-1" id="{{ $kintai_tag->tag->tag_name }}"><i class="las la-times-circle"></i></a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <p class="col-span-12 text-2xl mb-4 border-l-4 border-blue-500 pl-2">勤怠概要</p>
            <p class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm">出勤日</p>
            <p class="col-span-2 border border-black text-sm py-2 text-center">{{ \Carbon\Carbon::parse($kintai->work_day)->isoFormat('YYYY年MM月DD日(ddd)') }}</p>
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