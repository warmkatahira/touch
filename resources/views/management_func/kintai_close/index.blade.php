<script src="{{ asset('js/kintai_close.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('management_func.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">勤怠提出</p>
        </div>
        <!-- アラート表示 -->
        <x-alert/>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <table class="col-span-3">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-7/12 text-center">対象年月</th>
                        <th class="font-thin p-2 px-2 w-5/12 text-center">提出</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($not_close_kintais as $not_close_kintai)
                        <tr>
                            <td class="px-2 py-4 border text-center">{{ \Carbon\Carbon::parse($not_close_kintai->date)->isoFormat('YYYY年MM月') }}</td>
                            <td class="px-2 py-4 border text-center">
                                <a href="{{ route('kintai_close.closing', ['close_date' => $not_close_kintai->date]) }}" id="{{ \Carbon\Carbon::parse($not_close_kintai->date)->isoFormat('YYYY年MM月') }}" class="kintai_close_enter text-center rounded-lg bg-blue-200 py-2 px-5">提出する</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
