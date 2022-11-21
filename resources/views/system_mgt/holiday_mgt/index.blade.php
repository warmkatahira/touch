<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('system_mgt.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">休日管理</p>
        </div>
        <div class="grid grid-cols-12">
            <!-- データ出力 -->
            <p class="col-start-1 col-span-12 text-2xl mb-2 border-l-4 border-blue-500 pl-2">データ出力</p>
            <a href="{{ route('holiday_mgt.export') }}" class="col-span-2 py-2 rounded-lg text-center bg-blue-200">出力</a>
            <!-- データ取込 -->
            <p class="col-start-1 col-span-12 text-2xl mb-2 border-l-4 border-blue-500 pl-2 mt-5">データ取込</p>
            <form method="post" action="{{ route('holiday_mgt.import') }}" enctype="multipart/form-data" class="col-span-12 grid grid-cols-12">
                @csrf
                <input type="file" name="holiday_csv" class="col-span-12 text-sm" required>
                <button type="submit" class="col-start-1 col-span-2 bg-blue-200 text-center rounded-lg py-2 mt-3">取込</button>
            </form>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <!-- データ取込 -->
            <p class="col-start-1 col-span-12 text-2xl mb-2 border-l-4 border-blue-500 pl-2">休日一覧</p>
            <table class="col-start-1 col-span-4 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 w-5/12 text-center">日付</th>
                        <th class="font-thin p-2 w-7/12">備考</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($holidays as $holiday)
                        <tr class="hover:bg-teal-100">
                            <td class="p-2 border text-center">{{ \Carbon\Carbon::parse($holiday->holiday)->isoFormat('YYYY年MM月DD日(ddd)') }}</td>
                            <td class="p-2 border">{{ $holiday->holiday_note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
