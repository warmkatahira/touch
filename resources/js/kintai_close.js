// 提出するボタンが押下されたら
$("[class^=kintai_close_enter]").on("click",function(){
    const result = window.confirm(this.id + "の勤怠を提出しますか？");
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});