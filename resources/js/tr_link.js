// クリックしたリンクへ遷移
$('tr[data-href]').click(function () {
    window.location = $(this).attr('data-href');
});