<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-span-12 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2">管理者機能</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <x-menu-btn route="punch_manual.index" title="手動打刻" />
            <x-menu-btn route="customer_group.index" title="荷主グループ設定" />
        </div>
    </div>
</x-app-layout>
