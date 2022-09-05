// 登録用のモーダルを開く
$("[class^=punch_finish_confirm]").on("click",function(){
    modal = document.getElementById('punch_finish_confirm_modal');
    modal.classList.remove('hidden');
});
// 登録用のモーダルを閉じる
$("[class^=punch_finish_confirm_modal]").on("click",function(){
    modal = document.getElementById('punch_finish_confirm_modal');
    modal.classList.add('hidden');
});