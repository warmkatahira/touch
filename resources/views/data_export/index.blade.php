<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-span-12 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2">データ出力</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <x-menu-btn route="kintai_report_export.index" title="勤怠表出力" />
            <x-menu-btn route="csv_export.index" title="CSV出力" />
        </div>
    </div>
</x-app-layout>
