<div class="mt-5 p-5 border-2 border-blue-500 rounded-lg">
    <ul class="tab">
        <li class="tab_menu active">全て</li>
        @foreach($customergroups as $customer_group)
            <li class="tab_menu">{{ $customer_group->customer_group_name }}</li>
        @endforeach
        <li class="tab_menu">応援</li>
    </ul>
    <ul class="tab_detail_wrap show">
        <div class="grid grid-cols-12 gap-4 mt-5">
            @foreach($customers as $customer)
                <button type="button" class="working_time_input_modal_open col-span-4 text-center text-2xl bg-black text-white rounded-lg py-4 px-2" value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</button>
            @endforeach
        </div>
    </ul>
    @foreach($customergroups as $customer_group)
        <ul class="tab_detail_wrap">
            <div class="grid grid-cols-12 gap-4 mt-5">
                @foreach($customer_group->customers as $customer)
                    <button type="button" class="working_time_input_modal_open col-span-4 text-center text-2xl bg-black text-white rounded-lg py-4 px-2" value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</button>
                @endforeach
            </div>
        </ul>
    @endforeach
    @foreach($supportbases as $support_base)
        <ul class="tab_detail_wrap">
            <div class="grid grid-cols-12 gap-4 mt-5">
                @foreach($support_base->customers as $customer)
                    <button type="button" class="working_time_input_modal_open col-span-4 text-center text-2xl bg-black text-white rounded-lg py-4 px-2" value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</button>
                @endforeach
            </div>
        </ul>
    @endforeach
</div>