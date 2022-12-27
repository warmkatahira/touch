<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('data_export.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">勤怠表出力</p>
        </div>
        <!-- アラート表示 -->
        <x-alert/>
        <div class="grid grid-cols-12">
            <form method="POST" action="{{ route('kintai_report_export.export') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <label for="base" class="col-start-1 col-span-1 bg-black text-white text-center px-3 py-2">拠点</label>
                <select id="base" class="col-span-2 text-sm" name="base">
                    @foreach($bases as $base_id => $base_name)
                        <option value="{{ $base_id }}" {{ $base_id == old('base', Auth::user()->base_id) ? 'selected' : '' }}>{{ $base_name }}</option>
                    @endforeach
                </select>
                <label for="month" class="col-start-1 col-span-1 bg-black text-white text-center px-3 py-2 mt-1">出力年月</label>
                <input type="month" id="month" class="col-span-2 text-sm mt-1" name="month" value="{{ \Carbon\Carbon::now()->isoFormat('YYYY-MM') }}">
                <!-- 出力ボタン -->
                <button type="submit" class="col-start-1 col-span-3 text-center rounded-lg bg-blue-200 mt-3 py-5">出力</button>
            </form>
        </div>
    </div>
</x-app-layout>
