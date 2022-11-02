// 要素を取得
const punch_enter_form = document.getElementById('punch_enter_form');
const punch_key = document.getElementById('punch_key');

// 従業員名ボタンが押下されたら
$("[class^=punch_enter]").on("click",function(){
    // 勤怠IDをセット
    punch_key.value = this.value;
    // 次の画面へ移動
    punch_enter_form.submit();
});