<div class="mx-5 mb-2">
    @if(session('punch_type'))
        <script src="{{ asset('js/punch_complete_popup.js') }}" defer></script>
        <link rel="stylesheet" href="{{ asset('css/punch_complete_popup.css') }}">
        <div class="punch_finish grid grid-cols-12">
            <div class="wrapper col-span-12 grid grid-cols-12 border-4 bg-gray-200">
                <p class="text-5xl text-center col-start-4 col-span-6 rounded-lg border-8 border-dotted border-blue-500 bg-blue-100 pt-12">{{ session('punch_type') }}</p>
                <p class="text-5xl text-center col-start-1 col-span-12 mt-5">{{ session('employee_name') }} さん</p>
                <img src="{{ asset('image/punch_finish.svg') }}" class="col-start-1 col-span-12 mx-auto block">
            </div>
        </div>
    @endif
</div>