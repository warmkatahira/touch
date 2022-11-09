// 削除ボタンが押下されたら
$("[id=tag_delete]").on("click",function(){
    const result = window.confirm('タグ削除を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});