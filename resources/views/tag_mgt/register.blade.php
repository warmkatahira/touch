<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('tag_mgt.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-2 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">タグ追加</p>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <form method="POST" action="{{ route('tag_mgt.register') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <label for="owner_role_id" class="col-start-1 col-span-2 bg-black text-white py-2 text-center">管理権限</label>
                <select id="owner_role_id" name="owner_role_id" class="col-span-2">
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
                <label for="tag_name" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">タグ名</label>
                <input type="text" id="tag_name" name="tag_name" class="col-span-2 mt-1" autocomplete="off" required>
                <button type="submit" class="col-start-1 col-span-4 text-center bg-blue-200 rounded-lg py-3 mt-5">追加</button>
            </form>
        </div>
    </div>
</x-app-layout>
