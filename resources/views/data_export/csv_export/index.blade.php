<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('data_export.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">CSV出力</p>
        </div>
        <div class="grid grid-cols-12">
            <form method="GET" action="{{ route('csv_export.export') }}" class="m-0 col-span-12 grid grid-cols-12">
                <!-- 出力内容 -->
                <label for="export_content" class="col-start-1 col-span-1 bg-black text-white text-center py-2">出力内容</label>
                <select id="export_content" name="export_content" class="col-span-3 border border-black">
                    @foreach (App\Consts\CsvOutputContentConsts::OUTPUT_CONTENT_LIST as $name => $number)
                        <option value="{{ $name }}">{{ $number }}</option>
                    @endforeach
                </select>
                <!-- 対象年月 -->
                <label for="search_month" class="col-start-1 col-span-1 bg-black text-white text-center py-2 mt-1">対象年月</label>
                <input type="month" id="search_month" name="search_month" class="col-span-2 border border-black mt-1" value="{{ \Carbon\Carbon::now()->isoFormat('YYYY-MM') }}">
                <!-- 拠点 -->
                <label for="search_base" class="col-start-1 col-span-1 bg-black text-white text-center py-2 mt-1">拠点</label>
                <select id="search_base" name="search_base" class="col-span-2 border border-black mt-1">
                    @foreach($bases as $base_id => $base_name)
                        <option value="{{ $base_id }}" {{ $base_id == Auth::user()->base_id ? 'selected' : '' }}>{{ $base_name }}</option>
                    @endforeach
                </select>
                <!-- 出力ボタン -->
                <button type="submit" class="col-start-1 col-span-3 text-center rounded-lg bg-blue-200 mt-3 py-5">出力</button>
            </form>
        </div>
    </div>
</x-app-layout>
