<div class="mx-5 mb-2">
    @if(session('punch_type'))
        <script src="{{ asset('js/punch_complete_popup.js') }}" defer></script>
        <link rel="stylesheet" href="{{ asset('css/punch_complete_popup.css') }}">
        <div class="punch_finish grid grid-cols-12 p-5">
            <div class="col-span-12 grid grid-cols-12 gap-x-4 bg-gray-200 border-8 border-dotted border-blue-500 px-5">
                <lord-icon src="https://cdn.lordicon.com/uutnmngi.json" trigger="loop" style="width:120px;height:120px" class="col-span-1 mx-auto block"></lord-icon>
                <p class="text-7xl text-center col-start-2 col-span-3 mt-7 text-orange-600"></lord-icon>{{ session('punch_type') }}</p>
                <p class="text-7xl col-start-6 col-span-7 mt-7 text-orange-600">{{ session('employee_name') }}さん</p>
                <p class="text-5xl text-center col-start-1 col-span-4 text-white bg-blue-600 rounded-t-lg pt-8 px-2">{{ '月間稼働可能時間' }}</p>
                <p class="text-5xl text-center col-start-5 col-span-4 text-white bg-blue-600 rounded-t-lg pt-8 px-2">{{ '総稼働時間' }}</p>
                <p class="text-5xl text-center col-start-9 col-span-4 text-white bg-blue-600 rounded-t-lg pt-8 px-2">{{ '稼働可能時間' }}</p>
                <p class="text-5xl text-center col-start-1 col-span-4 text-blue-600 rounded-b-lg border-4 border-blue-600 pt-8 px-2">{{ number_format(session('monthly_workable_time_setting'), 2) }}</p>
                <p class="text-5xl text-center col-start-5 col-span-4 text-blue-600 rounded-b-lg border-4 border-blue-600 pt-8 px-2">{{ number_format(session('total_month_working_time'), 2) }}</p>
                <p class="text-5xl text-center col-start-9 col-span-4 text-blue-600 rounded-b-lg border-4 border-blue-600 pt-8 px-2">{{ number_format(session('workable_times'), 2) }}</p>
                <p class="col-start-1 col-span-12 text-center text-7xl tracking-in-expand mt-5" style="font-family:Kaisei Decol">{{ session('message') }}</p>
            </div>
        </div>
    @endif
</div>