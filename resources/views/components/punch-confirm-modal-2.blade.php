<!-- 打刻確認モーダル -->
<div id="punch_confirm_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-10">
    <div class="relative top-52 mx-auto shadow-lg rounded-md bg-white">
        <!-- モーダルヘッダー -->
        <div class="flex justify-between items-center bg-blue-500 text-white text-xl rounded-t-md px-4 py-2">
            <p id="modal_title" class="text-2xl">{{ $message }}</p>
        </div>
        <!-- モーダルボディー -->
        <div class="p-10">
            <div class="grid grid-cols-12">
                <p id="punch_target_employee_name" class="col-span-12 text-4xl mb-10">{{ $employee }}さん</p>
                <a id="punch_confirm_enter" class="cursor-pointer rounded-lg text-white bg-black text-center p-4 col-span-5 text-4xl">{{ $enterbtntext }}</a>
                <a id="punch_confirm_cancel" class="cursor-pointer rounded-lg text-white bg-red-400 text-center p-4 col-start-8 col-span-5 text-4xl">キャンセル</a>
            </div>
        </div>
    </div>
</div>