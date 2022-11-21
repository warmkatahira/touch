<script src="{{ asset('js/tag_detail.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('tag_mgt.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-10 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">タグ詳細</p>
            <a href="{{ route('tag_mgt.delete', ['tag_id' => $tag->tag_id]) }}" id="tag_delete" class="col-start-12 col-span-1 text-xl py-4 rounded-lg text-center bg-red-500 text-white mb-5">削除</a>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <form method="POST" action="{{ route('tag_mgt.modify') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <label for="owner_role_id" class="col-start-1 col-span-2 bg-black text-white py-2 text-center">管理権限</label>
                <select id="owner_role_id" name="owner_role_id" class="col-span-2">
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}" {{ $role->role_id == old('role', $tag->owner_role_id) ? 'selected' : '' }}>{{ $role->role_name }}</option>
                    @endforeach
                </select>
                <label for="tag_name" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">タグ名</label>
                <input type="text" id="tag_name" name="tag_name" class="col-span-2 mt-1" autocomplete="off" value="{{ old('tag_name', $tag->tag_name) }}" required>
                <input type="hidden" name="tag_id" value="{{ $tag->tag_id }}">
                <button type="submit" class="col-start-1 col-span-4 text-center bg-blue-200 rounded-lg py-3 mt-5">変更</button>
            </form>
        </div>
    </div>
</x-app-layout>
