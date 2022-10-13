// 従業員ボタンが押下されたら
$("[class^=punch_begin_enter]").on("click",function(){
    const result = window.confirm("出勤打刻を実施しますか？\n\n" + this.innerHTML);
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        submit();
    } else {
        return false;
    }
});

// 出勤打刻タイプが押下されたら
$("[id=punch_begin_type]").on("click",function(){
    const punch_begin_type = document.getElementById('punch_begin_type');
    const punch_begin_type_label = document.getElementById('punch_begin_type_label');
    // checkboxがtrueなら「早出」、falseなら「通常」に書き換える
    punch_begin_type_label.innerHTML = punch_begin_type.checked ? '早出' : '通常';
});