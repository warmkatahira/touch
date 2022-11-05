// 削除ボタンが押下されたら
$("[id=kintai_delete]").on("click",function(){
    const result = window.confirm('勤怠削除を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});

// タグ削除ボタンが押下されたら
$("[class^=kintai_tag_delete]").on("click",function(){
    const result = window.confirm("タグを削除しますか？\n\n" + this.id);
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});