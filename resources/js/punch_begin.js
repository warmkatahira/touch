// 出勤打刻タイプが押下されたら
$("[id=punch_begin_type]").on("click",function(){
    // 要素を取得
    const punch_begin_type = document.getElementById('punch_begin_type');
    const punch_begin_type_label = document.getElementById('punch_begin_type_label');
    // checkboxがtrueなら「早出」、falseなら「通常」に書き換える
    punch_begin_type_label.innerHTML = punch_begin_type.checked ? '早出' : '通常';
});