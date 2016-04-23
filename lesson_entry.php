<?php
//自作関数の読み込み
require_once('function/function.php');

session_start();
session_regenerate_id();
if(isset($_SESSION['login'])==false)
{
    print 'ログインされていません。　<br />';
    print '<a href="toppage.php">ログイン画面へ</a>';
    exit();
}
else
{
    print 'ようこそ';
    print $_SESSION['name'];
    print '様';
    
}

?>


    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <title>BeFriends</title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:700,400">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

        <section class="contact" id="contact">
            <h2 class="heading">レッスン登録</h2>
            <form class="contact-form" method="post" action="lesson_entry_check.php">
                <input type="text" name="title" placeholder="レッスン名">
                <input type="datetime-local" name="starttime" step="3600">
                <select name="time">
                    <option value="0">レッスン時間を選んでください</option>
                    <option value="1">30分</option>
                    <option value="2">1時間</option>
                    <option value="3">1時間30分</option>
                    <option value="4">2時間</option>
                </select>
                <input type="text" name="location" placeholder="場所">
                <textarea name="detail" rows="5" cols="40" placeholder="詳細の記入をしてください"></textarea>
                <input type="submit" value="SEND">
            </form>
        </section>
        <footer class="footer">
            © sample site
        </footer>
        <script src="lib/placeholders.min.js"></script>
    </body>

    </html>