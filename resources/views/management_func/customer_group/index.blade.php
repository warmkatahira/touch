<script src="{{ asset('js/customer_group.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('management_func.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">荷主グループ設定</p>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <!-- 荷主グループ追加 -->
            <p class="col-start-1 col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2">荷主グループ追加</p>
            <label class="col-start-1 col-span-2 bg-black text-white text-center py-2 text-sm">荷主グループ名</label>
            <form method="POST" action="{{ route('customer_group.register_group') }}" class="m-0 col-span-4 grid grid-cols-12">
                @csrf
                <input type="text" id="register_customer_group_name" name="customer_group_name" class="col-span-9 text-sm" autocomplete="off" required>
                <button type="submit" id="customer_group_register" class="col-span-3 text-sm text-center bg-blue-600 text-white">追加</button>
            </form>
            <!-- 荷主グループ情報 -->
            <p class="col-start-1 col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2 mt-5">荷主グループ情報</p>
            <table class="col-start-1 col-span-7 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 w-3/12">拠点</th>
                        <th class="font-thin p-2 w-2/12 text-center">表示順</th>
                        <th class="font-thin p-2 w-4/12">荷主グループ名</th>
                        <th class="font-thin p-2 w-2/12 text-right">設定荷主数</th>
                        <th class="font-thin p-2 w-1/12 text-center">削除</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($customer_groups as $customer_group)
                        <tr class="hover:bg-teal-100" data-href="{{ route('customer_group.detail', ['customer_group_id' => $customer_group->customer_group_id]) }}">
                            <td class="p-2 border">{{ $customer_group->base->base_name }}</td>
                            <td class="p-2 border text-center">{{ $customer_group->customer_group_order }}</td>
                            <td class="p-2 border">{{ $customer_group->customer_group_name }}</td>
                            <td class="p-2 border text-right">{{ $customer_group->setting_customer_count() }}</td>
                            <td class="p-2 border text-center">
                                <a href="{{ route('customer_group.delete_group', ['customer_group_id' => $customer_group->customer_group_id]) }}" id="{{ $customer_group->customer_group_name }}" class="delete">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="hover" style="width:30px;height:30px"></lord-icon>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
