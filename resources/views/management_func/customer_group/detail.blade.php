<script src="{{ asset('js/customer_group.js') }}" defer></script>

<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('customer_group.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-span-11 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4 mb-5">荷主グループ詳細</p>
        </div>
        <div class="grid grid-cols-12 mt-5">
            <!-- グループ情報 -->
            <p class="col-start-1 col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2">グループ情報</p>
            <form method="POST" action="{{ route('customer_group.modify') }}" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <label class="col-start-1 col-span-2 bg-black text-white text-center py-2 text-sm">荷主グループ名</label>
                <input type="text" name="customer_group_name" class="col-span-3 border border-black text-sm pt-2 px-2" value="{{ $customer_group->customer_group_name }}" autocomplete="off" required>
                <label class="col-start-1 col-span-2 bg-black text-white text-center py-2 text-sm mt-1">表示順</label>
                <input type="tel" name="customer_group_order" class="col-span-1 border border-black text-sm pt-2 px-2 mt-1" value="{{ $customer_group->customer_group_order }}" required>
                <input type="hidden" name="customer_group_id" value="{{ $customer_group->customer_group_id }}">
                <button type="submit" id="customer_group_modify" class="col-start-1 col-span-3 rounded-lg text-sm bg-blue-600 text-white mt-3 py-3">変更</button>
            </form>
            <!-- 新規設定 -->
            <p class="col-start-1 col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2 mt-5">荷主設定</p>
            <label class="col-start-1 col-span-2 bg-black text-white text-center py-2 text-sm">設定荷主選択</label>
            <form method="POST" action="{{ route('customer_group.register_setting') }}" class="m-0 col-span-4 grid grid-cols-12">
                @csrf
                <select name="customer" class="col-span-9 text-sm">
                    @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="customer_group_id" value="{{ $customer_group->customer_group_id }}">
                <button type="submit" class="col-span-3 text-sm text-center bg-blue-600 text-white">設定</button>
            </form>
            <!-- 現状の設定 -->
            <p class="col-start-1 col-span-2 text-2xl mb-2 border-l-4 border-blue-500 pl-2 mt-5">現状の荷主設定</p>
            <table class="col-start-1 col-span-4 text-sm">
                <thead>
                    <tr class="text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 w-9/12">荷主名</th>
                        <th class="font-thin p-2 w-3/12 text-center">削除</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($customer_groups as $customer_group)
                        <tr class="hover:bg-teal-100">
                            <td class="p-2 border">{{ $customer_group->customer_name }}</td>
                            <td class="p-2 border text-center">
                                <a href="{{ route('customer_group.delete_setting', ['customer_id' => $customer_group->customer_id]) }}" id="{{ $customer_group->customer_name }}" class="delete">
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
