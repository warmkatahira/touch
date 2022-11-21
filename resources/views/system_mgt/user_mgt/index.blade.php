<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('system_mgt.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">ユーザー管理</p>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <table class="col-span-12 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th class="font-thin p-2 px-2 w-2/12 text-center">名前</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-center">メールアドレス</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-center">ユーザー名</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-center">権限</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-center">拠点</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-center">ステータス</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($users as $user)
                        <tr class="hover:bg-teal-100" data-href="{{ route('user_mgt.detail', ['id' => $user->id]) }}">
                            <td class="p-1 px-2 border text-center">{{ $user->name }}</td>
                            <td class="p-1 px-2 border text-center">{{ $user->email }}</td>
                            <td class="p-1 px-2 border text-center">{{ $user->user_name }}</td>
                            <td class="p-1 px-2 border text-center">{{ $user->role->role_name }}</td>
                            <td class="p-1 px-2 border text-center">{{ $user->base->base_name }}</td>
                            <td class="p-1 px-2 border text-center">{{ $user->status == 1 ? '有効' : '無効' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
