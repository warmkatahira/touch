<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-start-1 col-span-4 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2">システム管理</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <a href="{{ route('user_mgt.index') }}" class="col-span-3 text-center rounded-lg py-5 bg-gradient-to-r from-blue-200 to-sky-300">ユーザー管理</a>
            <a href="{{ route('tag_mgt.index') }}" class="col-span-3 text-center rounded-lg py-5 bg-gradient-to-r from-blue-200 to-sky-300">タグ管理</a>
        </div>
    </div>
</x-app-layout>
