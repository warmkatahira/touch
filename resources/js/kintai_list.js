// クリックした勤怠の詳細へ遷移
$('tr[data-href]').click(function () {
    window.location = $(this).attr('data-href');
});

// チェックアイコン(thタグ)を押下したら
$('#all_check').on("click",function(){
    // チェックボックス要素関連の情報を取得
    const [chk, count, all] = get_checkbox();
    // チェックボックスがONの要素数と取得した全ての要素数が同じかどうかでONにするかOFFにするか判定
    if (count == all) {
        for(i = 0; i < chk.length; i++) {
            // OFF
            chk[i].checked = false
        }
    } else {
        for(i = 0; i < chk.length; i++) {
            // ON
            chk[i].checked = true
        }
    }
});

function get_checkbox(){
    // name属性がchk[]の要素を取得
    const chk = document.getElementsByName("chk[]");
    // カウント用の変数をセット
    let count = 0;
    let all = 0;
    // 取得した要素の分だけループ処理
    for (let i = 0; i < chk.length; i++) {
        // 要素の数をカウントしている
        all++;
        // チェックボックスがONになっている要素をカウント
        if (chk[i].checked) {
            count++;
        }
    }
    return [chk, count, all];
}

// 管理者確認実行ボタンが押下されたら
$("[id=manager_check_enter]").on("click",function(){
    // チェックボックス要素関連の情報を取得
    const [chk, count, all] = get_checkbox();
    try {
        // チェックが入っている要素が無ければ処理を中断
        if (count == 0) {
            throw new Error('確認印を押す勤怠を選択して下さい。');
        }
        // 確認メッセージを表示
        const result = window.confirm(count + '件の勤怠を確認済みにしますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            // フォームを送信
            const manager_check_form = document.getElementById('manager_check_form');
            manager_check_form.submit();
        }
    } catch (e) {
        alert(e.message);
    }
});