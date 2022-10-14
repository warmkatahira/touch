<div class="mx-5 mb-2">
    @if(session('punch_type'))
        <script src="{{ asset('js/punch_complete_popup.js') }}" defer></script>
        <link rel="stylesheet" href="{{ asset('css/punch_complete_popup.css') }}">
        <div class="punch_finish grid grid-cols-12 p-5">
            <div class="col-span-12 grid grid-cols-12 bg-gray-200 border-8 border-dotted border-blue-500">
                <lord-icon src="https://cdn.lordicon.com/uutnmngi.json" trigger="loop" style="width:150px;height:150px" class="col-span-12 mx-auto block"></lord-icon>
                <p class="text-8xl text-center col-start-4 col-span-6 rounded-lg mt-5"></lord-icon>{{ session('punch_type') }}</p>
                <p class="text-5xl text-center col-start-1 col-span-12">{{ session('employee_name') }}さん</p>
                <img src="{{ asset('image/finish.svg') }}" class="col-start-1 col-span-12 mx-auto block">
            </div>
        </div>
    @endif
</div>