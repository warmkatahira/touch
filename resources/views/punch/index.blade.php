<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 font-semibold text-xl text-gray-800 p-2">
                打刻画面
            </div>
            <div class="col-start-12 text-right">
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ログイン</a>
            </div>
        </div>
    </x-slot>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12">
            <div class="text-6xl col-start-1 col-span-1 text-right">
                {{ \Carbon\Carbon::today()->format('d') }}<span class="text-2xl">日</span>
            </div>
            <div class="text-5xl col-start-2 col-span-1 text-left">
                <p class="text-blue-500 py-2 ml-2">水</p>
            </div>
            <div class="col-start-3 col-span-3 text-6xl text-left">
                18:15:20
            </div>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-10">
            @foreach($employees as $employee)
                <button class="col-span-3 bg-black text-white text-center text-2xl rounded-lg px-8 py-10 hover:bg-sky-500">{{ $employee->employee_name }}</button>
            @endforeach
        </div>
    </div>
</x-app-layout>
