// 要素を取得
const punch_confirm_enter = document.getElementById('punch_confirm_enter');
const early_work_select_info_id = document.getElementById('early_work_select_info');
const message = document.getElementById('message');

// 出勤打刻タイプが押下されたら
$("[id=punch_begin_type]").on("click",function(){
    // 要素を取得
    const punch_begin_type = document.getElementById('punch_begin_type');
    const punch_begin_type_label = document.getElementById('punch_begin_type_label');
    // checkboxがtrueなら「早出」、falseなら「通常」に書き換える
    punch_begin_type_label.innerHTML = punch_begin_type.checked ? '早出' : '通常';
    // 早出状態の時の処理
    if(punch_begin_type.checked){
        // 早出時間の選択を初期化
        var early_work_select_info_name = document.getElementsByName("early_work_select_info");
        for(var i = 0; i < early_work_select_info_name.length; i++){
            const element = document.getElementById(early_work_select_info_name[i].id);
            const element_label = document.getElementById(early_work_select_info_name[i].id + '_label');
            element.checked = false;
            element_label.classList.remove('bg-blue-200');
        }
        // 出勤ボタンを非表示
        punch_confirm_enter.classList.add('hidden');
        early_work_select_info_id.classList.remove('hidden');
        message.classList.remove('hidden');
    }else{
        // 出勤ボタンを表示
        punch_confirm_enter.classList.remove('hidden');
        early_work_select_info_id.classList.add('hidden');
        message.classList.add('hidden');
    }
});

// 早出時間が選択されたら
$("[class^=early_work_select_info]").on("click",function(){
    var early_work_select_info = document.getElementsByName("early_work_select_info");
    for(var i = 0; i < early_work_select_info.length; i++){
        if(early_work_select_info[i].checked) {
            // 選択要素のCSSを調整
            const element = document.getElementById(early_work_select_info[i].id + '_label');
            element.classList.add('bg-blue-200');
        }
        if(!early_work_select_info[i].checked) {
            // 非選択要素のCSSを調整
            const element = document.getElementById(early_work_select_info[i].id + '_label');
            element.classList.remove('bg-blue-200');
        }
    }
    // 出勤ボタンを表示
    punch_confirm_enter.classList.remove('hidden');
});