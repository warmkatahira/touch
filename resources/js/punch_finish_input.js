const input_customer_id = document.getElementById('input_customer_id');
const input_customer_name = document.getElementById('input_customer_name');
const input_working_time = document.getElementById('input_working_time');

// 荷主稼働時間入力モーダルを開く
$("[class^=working_time_input_modal_open]").on("click",function(){
    const modal = document.getElementById('working_time_input_modal');
    modal.classList.remove('hidden');
    // 入力対象の荷主情報を出力
    input_customer_id.value = this.value;
    input_customer_name.innerHTML = this.innerHTML;
});

// 荷主稼働時間入力モーダルを閉じる
$("[class^=working_time_input_modal_close]").on("click",function(){
    const modal = document.getElementById('working_time_input_modal');
    modal.classList.add('hidden');
    // 稼働時間の数値を初期化
    input_working_time.innerHTML = '0.00';
});

// 押下された数値をプラスする
$("[class^=input_time]").on("click",function(){
    input_working_time.innerHTML = (Number(this.innerHTML) + Number(input_working_time.innerHTML)).toFixed(2);
});

// 稼働時間のクリアボタンが押下されたら数値を初期化
$("[id=input_working_time_clear]").on("click",function(){
    input_working_time.innerHTML = '0.00';
});