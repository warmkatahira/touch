<x-app-layout>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('punch.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white hover:bg-sky-500 mb-5">戻る</a>
            <p class="col-start-4 col-span-6 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">今日の勤怠</p>
        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <div class="col-span-12 grid grid-cols-12 gap-4 mt-5">
                @foreach($employees as $employee)
                    <div class="col-span-3 grid grid-cols-12 text-3xl rounded-lg px-8 {{ GetTodayKintaiStatusFunc::Color(GetTodayKintaiStatusFunc::Status($employee->employee_no)) }}">
                        <p class="col-span-12 text-left mt-3">{{ GetTodayKintaiStatusFunc::Status($employee->employee_no) }}</p>
                        <p class="col-span-12 text-center py-5">{{ $employee->employee_name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
