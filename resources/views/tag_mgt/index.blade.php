<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('system_mgt.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-2 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">タグ管理</p>
            <a href="{{ route('tag_mgt.register_index') }}" class="col-start-12 col-span-1 text-xl py-4 rounded-lg text-center bg-blue-200 mb-5">追加</a>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <table class="col-span-4 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-3/12 text-center">管理権限</th>
                        <th class="font-thin p-2 px-2 w-6/12 text-center">タグ名</th>
                        <th class="font-thin p-2 px-2 w-3/12 text-center">登録タグ数</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($tags as $tag)
                        <tr class="hover:bg-teal-100" data-href="{{ route('tag_mgt.detail', ['tag_id' => $tag->tag_id]) }}">
                            <td class="p-1 px-2 border text-center">{{ $tag->role->role_name }}</td>
                            <td class="p-1 px-2 border text-center">{{ $tag->tag_name }}</td>
                            <td class="p-1 px-2 border text-center">{{ $tag->kintai_tags_count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
