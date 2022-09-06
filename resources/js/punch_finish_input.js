const modal = document.getElementById('working_time_input_modal');
const input_customer_id = document.getElementById('input_customer_id');
const input_customer_name = document.getElementById('input_customer_name');
const input_working_time = document.getElementById('input_working_time');
const input_working_time_info = document.getElementById('input_working_time_info');

// 荷主稼働時間入力モーダルを開く
$("[class^=working_time_input_modal_open]").on("click",function(){
    modal.classList.remove('hidden');
    // 入力対象の荷主情報を出力
    input_customer_id.value = this.value;
    input_customer_name.innerHTML = this.innerHTML;
    // 稼働時間の数値を初期化
    input_working_time.innerHTML = '0.00';
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

// 入力が押下されたら
$("[id=working_time_input_enter]").on("click",function(){
    // 表示させる要素を作成して表示
    const working_time_input = document.createElement('button');
    working_time_input.id = 'working_time_input_' + input_customer_id.value;
    working_time_input.classList.add('working_time_info_delete', 'col-span-4', 'py-5', 'text-center', 'bg-green-200', 'text-2xl', 'rounded-lg', 'cursor-pointer', 'working_time_input_' + input_customer_id.value);
    working_time_input.innerHTML = input_customer_name.innerHTML + ' / ' + input_working_time.innerHTML;
    // 送信する要素を作成して表示
    const working_time_hidden = document.createElement('input');
    working_time_hidden.type = 'hidden';
    working_time_hidden.id = 'working_time_input_' + input_customer_id.value + '_hidden';
    working_time_hidden.classList.add('working_time_input_' + input_customer_id.value);
    working_time_hidden.value = input_working_time.innerHTML;
    working_time_hidden.name = 'working_time_input' + '[' + input_customer_id.value + ']';
    input_working_time_info.append(working_time_input, working_time_hidden);
    // モーダルを閉じる
    modal.classList.add('hidden');
});

// 押下された要素を削除
$(document).on("click", ".working_time_info_delete", function () {
    const delete_target_1 = document.getElementById(this.id);
    const delete_target_2 = document.getElementById(this.id + '_hidden');
    delete_target_1.remove();
    delete_target_2.remove();
});