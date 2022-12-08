<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-span-12 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2">その他</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <x-menu-btn route="over_time_rank.index" title="残業ランキング" />
            <x-menu-btn route="customer_working_time_rank.index" title="荷主稼働ランキング" />
        </div>
    </div>
</x-app-layout>
