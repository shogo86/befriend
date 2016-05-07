<?php

require_once(__DIR__ . '/config.php');

$fbLogin = new MyApp\FacebookLogin();


//ログイン状態かどうか
if ($fbLogin->isLoggedIn()) {
    //id,name,linkを取得する
    $me = $_SESSION['me'];
    
    //emailを取得する
    $fb = new MyApp\Facebook($me->fb_access_token);
    $userNode = $fb->getUserNode();
    
    //IDを変数に入れる
    $fb_user_id = $me->fb_user_id;
    
    //投稿情報を取得する
    $posts = $fb->getPosts();
    
    //CSRF対策
    //セッションにTokenを仕込む
    MyApp\Token::create();

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
            <form class="contact-form" method="post" action="lesson_entry_done.php">
                <input type="date" name="day" min="2016-05-01" required>
                <select name="time" required>
                    <option value="">レッスン時間を選んでください</option>
                    <option value="1">8:00-9:00</option>
                    <option value="2">9:00-10:00</option>
                    <option value="3">10:00-11:00</option>
                    <option value="4">11:00-12:00</option>
                </select>
                <select name="state" required>
                    <option value="">都道府県を選択してください</option>
                    <option value="1">東京</option>
                    <option value="2">埼玉</option>
                    <option value="3">千葉</option>
                    <option value="4">神奈川</option>
                </select>
                <input type="text" name="city" placeholder="市区町村を入力してください。" required>
                <input type="text" name="street" placeholder="詳細住所を入力してください。" required>
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