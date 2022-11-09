<script src="{{ asset('js/tag_detail.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('user_mgt.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-2 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">ユーザー詳細</p>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <form method="POST" action="{{ route('user_mgt.modify') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <label for="name" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">名前</label>
                <input type="text" id="name" name="name" class="col-span-2 mt-1" autocomplete="off" value="{{ old('name', $user->name) }}" required>
                <label for="email" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">メールアドレス</label>
                <input type="email" id="email" name="email" class="col-span-2 mt-1" autocomplete="off" value="{{ old('email', $user->email) }}" required>
                <label for="user_name" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">ユーザー名</label>
                <input type="text" id="user_name" name="user_name" class="col-span-2 mt-1" autocomplete="off" value="{{ old('user_name', $user->user_name) }}" required>
                <label for="role" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">権限</label>
                <select id="role" name="role" class="col-span-2 mt-1">
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}" {{ $role->role_id == old('role', $user->role_id) ? 'selected' : '' }}>{{ $role->role_name }}</option>
                    @endforeach
                </select>
                <label for="base" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">拠点</label>
                <select id="base" name="base" class="col-span-2 mt-1">
                    @foreach($bases as $base)
                        <option value="{{ $base->base_id }}" {{ $base->base_id == old('base', $user->base_id) ? 'selected' : '' }}>{{ $base->base_name }}</option>
                    @endforeach
                </select>
                <label for="status" class="col-start-1 col-span-2 bg-black text-white py-2 text-center mt-1">ステータス</label>
                <select id="status" name="status" class="col-span-2 mt-1">
                    <option value="0" {{ 0 == old('status', $user->status) ? 'selected' : '' }}>無効</option>
                    <option value="1" {{ 1 == old('status', $user->status) ? 'selected' : '' }}>有効</option>
                </select>
                <input type="hidden" name="id" value="{{ $user->id }}">
                <button type="submit" class="col-start-1 col-span-4 text-center bg-blue-200 rounded-lg py-3 mt-5">変更</button>
            </form>
        </div>
    </div>
</x-app-layout>
