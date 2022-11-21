// 削除ボタンが押下されたら
$("[class^=delete]").on("click",function(){
    const customer_name = this.id;
    const result = window.confirm("以下の設定を削除しますか？\n\n" + customer_name);
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});

// 変更ボタンが押下されたら
$("[id=customer_group_modify]").on("click",function(){
    const result = window.confirm("グループ情報を変更しますか？");
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});

// グループ追加ボタンが押下されたら
$("[id=customer_group_register]").on("click",function(){
    const customer_group_name = document.getElementById('register_customer_group_name');
    const result = window.confirm("以下のグループを追加しますか？\n\n" + customer_group_name.value);
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});