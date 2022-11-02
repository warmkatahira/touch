const modal = document.getElementById('working_time_input_modal');
const input_customer_id = document.getElementById('input_customer_id');
const input_customer_name = document.getElementById('input_customer_name');
const input_working_time = document.getElementById('input_working_time');
const input_working_time_info = document.getElementById('input_working_time_info');
const input_time_left = document.getElementById('input_time_left');
const input_time_left_modal = document.getElementById('input_time_left_modal');
const rest_time = document.getElementById('rest_time');
const org_rest_time = document.getElementById('org_rest_time');
const working_time = document.getElementById('working_time');
const org_working_time = document.getElementById('org_working_time');
const punch_confirm_modal = document.getElementById('punch_confirm_modal');
const punch_enter_form = document.getElementById('punch_enter_form');

// 荷主稼働時間入力モーダルを開く
$("[class^=working_time_input_modal_open]").on("click",function(){
    modal.classList.remove('hidden');
    // 入力対象の荷主情報を出力
    input_customer_id.value = this.value;
    input_customer_name.innerHTML = this.innerHTML;
    // 稼働時間の数値を初期化
    input_working_time.innerHTML = '0.00';
    // 残り入力時間を更新
    input_time_left_modal.innerHTML = Number(input_time_left.innerHTML).toFixed(2);
});

// 荷主稼働時間入力モーダルを閉じる
$("[class^=working_time_input_modal_close]").on("click",function(){
    modal.classList.add('hidden');
});

// 押下された数値をプラスする
$("[class^=input_time]").on("click",function(){
    input_working_time.innerHTML = (Number(this.innerHTML) + Number(input_working_time.innerHTML)).toFixed(2);
});

// 稼働時間のクリアボタンが押下されたら数値を初期化
$("[id=input_working_time_clear]").on("click",function(){
    input_working_time.innerHTML = '0.00';
});

// 残り時間を全て入力ボタンが押下された場合
$("[id=all_input]").on("click",function(){
    input_working_time.innerHTML = input_time_left_modal.innerHTML;
});

// 時間入力が押下されたら
$("[id=working_time_input_enter]").on("click",function(){
    try {
        // 既に存在する荷主ではないかチェック
        if(document.getElementById('working_time_input_' + input_customer_id.value) != null){
            throw new Error('既に存在する荷主です。');
        }
        // 時間が入力されているかチェック
        if(0 == Number(input_working_time.innerHTML)){
            throw new Error('時間が入力されていません。');
        }
        // 残り入力時間より大きい時間ではないかチェック
        if(Number(input_time_left.innerHTML) < Number(input_working_time.innerHTML)){
            throw new Error('入力時間が稼働時間を超えています。');
        }
        // 表示させる要素を作成して表示
        const working_time_input = document.createElement('button');
        working_time_input.id = 'working_time_input_' + input_customer_id.value;
        working_time_input.classList.add('working_time_info_delete', 'col-span-4', 'py-5', 'text-center', 'bg-blue-200', 'text-xl', 'rounded-lg', 'cursor-pointer', 'working_time_input_' + input_customer_id.value);
        working_time_input.innerHTML = input_customer_name.innerHTML + "<br>" + input_working_time.innerHTML;
        // 送信する要素を作成して表示
        const working_time_hidden = document.createElement('input');
        working_time_hidden.type = 'hidden';
        working_time_hidden.id = 'working_time_input_' + input_customer_id.value + '_hidden';
        working_time_hidden.classList.add('working_time_input', 'working_time_input_' + input_customer_id.value);
        working_time_hidden.value = input_working_time.innerHTML;
        working_time_hidden.name = 'working_time_input' + '[' + input_customer_id.value + ']';
        input_working_time_info.append(working_time_input, working_time_hidden);
        // 残り入力時間を更新
        input_time_left.innerHTML = (Number(input_time_left.innerHTML) - Number(input_working_time.innerHTML)).toFixed(2);
        // モーダルを閉じる
        modal.classList.add('hidden');
    } catch (e) {
        alert(e.message);
    }
});

// 押下された荷主稼働時間要素を削除
$(document).on("click", ".working_time_info_delete", function () {
    const delete_target_1 = document.getElementById(this.id);
    const delete_target_2 = document.getElementById(this.id + '_hidden');
    // 残り入力時間を更新
    input_time_left.innerHTML = (Number(input_time_left.innerHTML) + Number(delete_target_2.value)).toFixed(2);
    // 要素を削除
    delete_target_1.remove();
    delete_target_2.remove();
});

// 休憩未取得時間が変更されたら
$("[class^=no_rest_time_select]").on("click",function(){
    no_rest_time_select();
});

function no_rest_time_select(){
    var no_rest_times = document.getElementsByName("no_rest_time");
    for(var i = 0; i < no_rest_times.length; i++){
        if(no_rest_times[i].checked) {
            const element = document.getElementById(no_rest_times[i].id + '_label');
            element.classList.add('bg-blue-200');
            // 休憩時間を変更
            const select_no_rest_time = document.getElementById(no_rest_times[i].id);
            rest_time.value = Number(org_rest_time.value) - Number(select_no_rest_time.value);
            // 勤務時間を変更
            working_time.value = ((Number(org_working_time.value) + Number(select_no_rest_time.value)) / 60).toFixed(2);
            // 残り入力時間を変更
            input_time_left.innerHTML = ((Number(org_working_time.value) + Number(select_no_rest_time.value)) / 60).toFixed(2);
            let elements = document.getElementsByClassName('working_time_input');
            for(var k = 0; k < elements.length; k++){
                input_time_left.innerHTML = (Number(input_time_left.innerHTML) - Number(elements[k].value)).toFixed(2);
            }
        }
        if(!no_rest_times[i].checked) {
            // 非選択要素のCSSを調整
            const element = document.getElementById(no_rest_times[i].id + '_label');
            element.classList.remove('bg-blue-200');
        }
    }
}

// 画面読み込み時の処理
window.onload = function(){
    no_rest_time_select();
}

// 退勤確定処理が押下されたら
$("[id=punch_finish_enter]").on("click",function(){
    try {
        // 残り入力時間が0以外だったら処理を中断
        if (Number(input_time_left.innerHTML) > 0) {
            throw new Error('入力されていない稼働時間があります。');
        }
        if (Number(input_time_left.innerHTML) < 0) {
            throw new Error('荷主稼働時間がマイナスになっています。\n時間を調整して下さい。');
        }
        // モーダルを表示
        punch_confirm_modal.classList.remove('hidden');
    } catch (e) {
        alert(e.message);
        return false;
    }
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