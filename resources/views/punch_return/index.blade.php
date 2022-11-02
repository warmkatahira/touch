<script src="{{ asset('js/punch_common.js') }}" defer></script>

<x-app-layout>
    <x-loading></x-loading>
    <div class="py-5 mx-5">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ route('punch.index') }}" class="col-start-1 col-span-1 text-xl py-4 rounded-lg text-center bg-black text-white mb-5">戻る</a>
            <p class="col-start-2 col-span-2 text-center text-4xl bg-emerald-100 border-b-4 border-emerald-400 rounded-t-lg py-2 h-3/4">戻り</p>
            <x-clock/>
        </div>
        <form method="post" id="punch_enter_form" action="{{ route('punch_return.enter') }}" class="m-0">
            @csrf
            <!-- 従業員名ボタンを表示 -->
            <x-punch-employee-btn :employees="$employees" id="kintai_id"/>
        </form>
    </div>
    <!-- 打刻確認モーダル -->
    <x-punch-confirm-modal-1 proc="戻り"/>
</x-app-layout>
