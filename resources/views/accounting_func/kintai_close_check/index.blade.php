<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('accounting_func.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">勤怠提出確認</p>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <!-- 検索条件 -->
            <div class="col-span-6 grid grid-cols-12 mb-2 border border-black p-5 rounded-lg bg-sky-100">
                <p class="col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2">検索条件</p>
                <form method="GET" action="{{ route('kintai_close_check.search') }}" class="m-0 col-span-12 grid grid-cols-12">
                    <!-- 対象年月 -->
                    <label for="search_month" class="col-start-1 col-span-2 bg-black text-white text-center py-2 text-sm">対象年月</label>
                    <input type="month" id="search_month" name="search_month" class="col-span-4 border border-black text-sm" value="{{ session('search_month') }}">
                    <!-- 検索ボタン -->
                    <button type="submit" class="col-start-10 col-span-3 text-sm text-center bg-black text-white rounded-lg mt-1"><i class="las la-search la-2x"></i></button>
                </form>
            </div>
            <!-- 荷主稼働ランキング -->
            <table class="col-start-1 col-span-6 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th class="font-thin p-2 px-2 w-3/12">年月</th>
                        <th class="font-thin p-2 px-2 w-5/12">拠点</th>
                        <th class="font-thin p-2 px-2 w-4/12">提出日時</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($kintai_closes as $kintai_close)
                        <tr class="hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ \Carbon\Carbon::parse($kintai_close->close_date)->isoFormat('YYYY年MM月') }}</td>
                            <td class="p-1 px-2 border">{{ $kintai_close->base_name }}</td>
                            <td class="p-1 px-2 border">{{ $kintai_close->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
