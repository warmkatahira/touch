<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-span-12 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2">システム管理</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <x-menu-btn route="user_mgt.index" title="ユーザー管理" />
            <x-menu-btn route="tag_mgt.index" title="タグ管理" />
            <x-menu-btn route="holiday_mgt.index" title="休日管理" />
        </div>
    </div>
</x-app-layout>
