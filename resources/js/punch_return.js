// 従業員ボタンが押下されたら
$("[class^=punch_return_enter]").on("click",function(){
    const result = window.confirm("戻り打刻を実施しますか？\n\n" + this.innerHTML);
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        submit();
    } else {
        return false;
    }
});