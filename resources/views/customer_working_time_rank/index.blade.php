<link rel="stylesheet" href="{{ asset('css/radio_btn.css') }}">

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-start-1 col-span-4 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2">荷主稼働ランキング</p>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <!-- 検索条件 -->
            <div class="col-span-12 grid grid-cols-12 mb-2 border border-black p-5 rounded-lg bg-sky-100">
                <p class="col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2">検索条件</p>
                <!-- 条件クリアボタン -->
                <a href="{{ route('customer_working_time_rank.index') }}" class="col-start-12 col-span-1 text-sm text-center bg-red-500 text-white py-1 rounded-lg mb-2"><i class="las la-trash-alt la-2x"></i></a>
                <form method="GET" action="{{ route('customer_working_time_rank.search') }}" class="m-0 col-span-12 grid grid-cols-12">
                    <!-- 対象年月 -->
                    <label for="search_month" class="col-start-1 col-span-1 bg-black text-white text-center py-2 text-sm">対象年月</label>
                    <input type="month" id="search_month" name="search_month" class="col-span-2 border border-black text-sm" value="{{ session('search_month') }}">
                    <!-- 拠点 -->
                    <label for="search_base" class="col-span-1 bg-black text-white text-center py-2 text-sm">拠点</label>
                    <select id="search_base" name="search_base" class="col-span-2 text-sm">
                        @foreach($bases as $base_id => $base_name)
                            <option value="{{ $base_id }}" {{ $base_id == session('search_base') ? 'selected' : '' }}>{{ $base_name }}</option>
                        @endforeach
                    </select>
                    <!-- 並び順 -->
                    <label class="col-span-1 bg-black text-white text-center py-2 text-sm">並び順</label>
                    <div class="col-span-2 grid grid-cols-12 radiobox">
                        <input type="radio" id="total" class="radio_btn hidden" name="search_orderby" value="total" {{ session('search_orderby') == 'total' ? 'checked' : '' }}>
                        <label for="total" class="bg-gray-200 px-4 py-2 col-start-1 col-span-4 text-center border border-black text-sm">合計</label>
                        <input type="radio" id="shain" class="radio_btn hidden" name="search_orderby" value="shain" {{ session('search_orderby') == 'shain' ? 'checked' : '' }}>
                        <label for="shain" class="bg-gray-200 px-4 py-2 col-span-4 text-center border-y border-r border-black text-sm">正社員</label>
                        <input type="radio" id="part" class="radio_btn hidden" name="search_orderby" value="part" {{ session('search_orderby') == 'part' ? 'checked' : '' }}>
                        <label for="part" class="bg-gray-200 px-4 py-2 col-span-4 text-center border-y border-r border-black text-sm">パート</label> 
                    </div>
                    <!-- 検索ボタン -->
                    <button type="submit" class="col-start-12 col-span-1 text-sm text-center bg-black text-white rounded-lg mt-1"><i class="las la-search la-2x"></i></button>
                </form>
            </div>
            <!-- 荷主稼働ランキング -->
            <table class="col-span-12 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-1/12">Rank</th>
                        <th class="font-thin p-2 px-2 w-2/12">拠点</th>
                        <th class="font-thin p-2 px-2 w-3/12">荷主名</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">総稼働時間(合計)</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">総稼働時間(正社員)</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">総稼働時間(パート)</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($customers as $key => $customer)
                        <tr class="hover:bg-teal-100" data-href="{{ route('customer_working_time_rank.detail', ['customer_id' => $customer->customer_id]) }}">
                            <td class="p-1 px-2 border">{{ ($customer->total_customer_working_time_total) == 0 ? '-' : sprintf('%02d', $key + 1) }}</td>
                            <td class="p-1 px-2 border">{{ $customer->base->base_name }}</td>
                            <td class="p-1 px-2 border">{{ $customer->customer_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($customer->total_customer_working_time_total / 60, 2).' 時間' }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($customer->total_customer_working_time_shain / 60, 2).' 時間' }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($customer->total_customer_working_time_part / 60, 2).' 時間' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
