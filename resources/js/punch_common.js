// 要素を取得
const punch_confirm_modal = document.getElementById('punch_confirm_modal');
const punch_key = document.getElementById('punch_key');
const punch_target_employee_name = document.getElementById('punch_target_employee_name');
const punch_confirm_enter = document.getElementById('punch_confirm_enter');
const punch_enter_form = document.getElementById('punch_enter_form');

// 打刻確認モーダルを開く
$("[class^=punch_enter]").on("click",function(){
    // モーダルを表示
    punch_confirm_modal.classList.remove('hidden');
    // 従業員番号(or 勤怠ID)と従業員名を出力
    punch_key.value = this.value;
    punch_target_employee_name.innerHTML = this.innerHTML + 'さん';
});

// 打刻確認モーダルを閉じる
$("[id=punch_confirm_cancel]").on("click",function(){
    // モーダルを非表示
    punch_confirm_modal.classList.add('hidden');
});

// 打刻実行ボタンが押下されたら
$("[id=punch_confirm_enter]").on("click",function(){
    // フォームをサブミット
    punch_enter_form.submit();
});