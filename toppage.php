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
    <header class="header">
        <p class="site-title-sub">Language Exchange Servise</p>
        <h1 class="site-title">世界と話そう</h1>
        <p class="site-description">100カ国以上のネイティブスピーカーと学び合おう</p>
        <div class="buttons">
            <div class="container">
                <div class="login">
                    <a class="button-facebook" href="login.php">Facebook Login</a>
            <!--<a class="button" href="#login">ログイン</a>
            <a class="button button-showy" href="#contact">新規登録</a> -->
                </div>
            </div>
        </div>
    </header>
    <section class="about" id="about">
        <h2 class="heading">ABOUT</h2>
        <p class="about-text">
            ここではあなたの最適な語学学習のパートナーを見つけることができます。
            <br> あなたの母国語を学んでいるネイティブスピーカーと、あなたが学びたい第２言語を練習し合いましょう。
        </p>
        <p class="about-text">
            これまで100以上の言語で100万回以上のレッスンが行われました。
            <br> ネイティブスピーカーと楽しく会話をして、ネイティブレベルへ語学力を高めましょう。
        </p>
    </section>
    <section class="works">
        <h2 class="heading">CASE</h2>
        <div class="works-wrapper">
            <div class="work-box tree">
                <img class="work-image" src="images/tree.jpg" alt="制作事例1">
                <div class="work-description">
                    <div class="work-description-inner">
                        <p class="work-text">
                            ひとつめの事例が入ります。
                            <br> 簡単な説明が入ります。
                            <br> レッスン：日本人とイギリス人
                            <br>
                            <a href="#" class="button button-ghost">READ MORE</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="work-box building">
                <img class="work-image" src="images/building.jpg" alt="制作事例2">
                <div class="work-description">
                    <div class="work-description-inner">
                        <p class="work-text">
                            ふたつめの事例が入ります。
                            <br> 簡単な説明が入ります。
                            <br> レッスン：フランス人と中国人
                            <br>
                            <a href="#" class="button button-ghost">READ MORE</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="work-box lake">
                <img class="work-image" src="images/lake.jpg" alt="制作事例3">
                <div class="work-description">
                    <div class="work-description-inner">
                        <p class="work-text">
                            みっつめの事例が入ります。
                            <br> 簡単な説明が入ります。
                            <br> レッスン：複数人での英会話
                            <br>
                            <a href="#" class="button button-ghost">READ MORE</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="work-box sky">
                <img class="work-image" src="images/sky.jpg" alt="制作事例4">
                <div class="work-description">
                    <div class="work-description-inner">
                        <p class="work-text">
                            よっつめの事例が入ります。
                            <br> 簡単な説明が入ります。
                            <br> レッスン：ホームパーティ
                            <br>
                            <a href="#" class="button button-ghost">READ MORE</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="skills">
        <h2 class="heading"></h2>
        <div class="skills-wrapper">
            <div class="skill-box">
                <i class="skill-icon fa fa-paint-brush"></i>
                <div class="skill-title">LESSON</div>
                <p class="skill-text">
                    あなたの暮らしている街のどこかで
                    <br> レッスンが行われています。
                    <br> レッスンを探して参加してみましょう。
                </p>
            </div>
            <div class="skill-box">
                <i class="skill-icon fa fa-lightbulb-o"></i>
                <div class="skill-title">EVENT</div>
                <p class="skill-text">
                    趣味を通して会話するイベントもあります。
                    <br> web共同開発からビアパーティまで
                    <br> 多くのイベントがあります。
                </p>
            </div>
            <div class="skill-box">
                <i class="skill-icon fa fa-code"></i>
                <div class="skill-title">CHAT</div>
                <p class="skill-text">
                    いきなり会うのに抵抗があれば、
                    <br> まずはチャットから始めましょう。
                    <br> ビデオチャットもあります。
                </p>
            </div>
        </div>
    </section>
    <section class="login" id="login">
        <h2 class="heading">ログイン</h2>
        <form class="contact-form" method="post" action="login_check.php">
            <input type="text" name="email" placeholder="メールアドレス">
            <input type="password" name="pass" placeholder="パスワード">
            <input type="submit" value="SEND">
        </form>
    </section>

    <section class="contact" id="contact">
        <h2 class="heading">新規登録</h2>
        <form class="contact-form" method="post" action="entry_check.php">
            <input type="text" name="name" placeholder="お名前">
            <input type="text" name="email" placeholder="メールアドレス">
            <input type="password" name="pass" placeholder="パスワード">
            <input type="password" name="pass2" placeholder="パスワード確認">
            <select name="main">
                <option value="0">得意な言語を選択してください</option>
                <option value="1">日本語</option>
                <option value="2">英語</option>
                <option value="3">中国語</option>
            </select>
            <select name="sub">
                <option value="0">学びたい言語を選択してください</option>
                <option value="1">日本語</option>
                <option value="2">英語</option>
                <option value="3">中国語</option>
            </select>
            <input type="submit" value="SEND">
        </form>
    </section>
    <footer class="footer">
        © sample site
    </footer>
    <script src="lib/placeholders.min.js"></script>
    
</body>

</html>