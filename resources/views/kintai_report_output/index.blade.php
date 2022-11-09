<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-start-1 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">勤怠表出力</p>
        </div>
        <div class="grid grid-cols-12">
            <form method="POST" action="{{ route('kintai_report_output.output') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <div class="col-span-12 grid grid-cols-12">
                    <label for="base" class="col-span-1 bg-black text-white text-center text-sm px-3 py-2">拠点</label>
                    <select id="base" class="col-span-2 text-sm" name="base">
                        @foreach($bases as $base)
                            <option value="{{ $base->base_id }}">{{ $base->base_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-12 grid grid-cols-12 mt-1">
                    <label for="month" class="col-span-1 bg-black text-white text-center text-sm px-3 py-2">出力年月</label>
                    <input type="month" id="month" class="col-span-2 text-sm" name="month" required>
                </div>
                <button type="submit" id="output" class="col-span-3 bg-blue-200 text-center rounded-lg p-3 mt-5">出力</button>
            </form>
        </div>
    </div>
</x-app-layout>
