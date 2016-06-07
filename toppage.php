<?php

require_once "ua.class.php";

$ua = new UserAgent();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>BeFriend</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:700,400">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
</head>

<body>
    <?php
    //モバイルの場合は停止画像の表示
    if($ua->set() === "mobile") {
        print '<header id="header_sp">';
    } else {
    //PC,タブレットの場合は切り替え画像の表示
        print '<header id="header_pc">';
    }
    ?>
        <div class="layerTransparen">
        <div id="gloval-header" class="ex-gloval-header">
            <p class="befriend">Befriend</p>
            <a href="login.php" class="facebook_start">Facebookでログイン</a>
            <a href="./EN/toppage.php" class="language_change">English</a>
            <!--
            <ul class="language">
                <li class=language_single>
                    <a href="">language</a>
                    <ul class="language_second">
                        <li><a href="http://www.google.co.jp/">日本語</a></li>
                        <li><a href="http://www.google.co.jp/">中国語</a></li>
                    </ul>
                </li>
            </ul>
            <!--<div class="after-gloval-header">
            </div>
            <div class="ex-gloval-header">
            </div>-->
        </div>
        <div class="header-contents">
        <p class="site-title-sub">Language Exchange Servise</p>
        <h1 class="site-title">世界と話そう</h1>
        <p class="site-description">100カ国以上のネイティブスピーカーと学び合おう</p>
        <div class="buttons">
        <!--<div class="container">-->
                    <a class="FbBtn" href="login.php">
                        <div class="FbBtnLabel">Facebookではじめる </div>
                    </a>
        <!--</div>-->
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
            <br> ネイティブスピーカーと楽しく会話をして、語学力を高めましょう。
        </p>
    </section>
    <!--
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
    -->
    <section class="skills">
        <h2 class="heading"></h2>
        <div class="skills-wrapper">
            <div class="skill-box">
                <!--<i class="skill-icon fa fa-paint-brush"></i>-->
                <div class="lesson_icon">
                    <img src="./images/icon_lesson.jpeg" width="200" height="200">
                </div>
                <div class="skill-title">LESSON</div>
                <p class="skill-text">
                    あなたの暮らしている街のどこかで
                    <br> レッスンが行われています。
                    <br> レッスンを探して参加してみましょう。
                </p>
            </div>
            <div class="skill-box">
                <div class="lesson_icon">
                    <img src="./images/icon_security.jpeg" width="200" height="200">
                </div>
                <!--<i class="skill-icon fa fa-code"></i>-->
                <div class="skill-title">SECURITY</div>
                <p class="skill-text">
                    facebookのIDがなければ、
                    <br> サービスを開始できません。
                    <br> ユーザー同士の評価システムもあります。
                </p>
            </div>
            <div class="skill-box">
                <div class="lesson_icon">
                    <img src="./images/icon_event.jpeg" width="200" height="200">
                </div>
                <!--<i class="skill-icon fa fa-lightbulb-o"></i>-->
                <div class="skill-title">EVENT</div>
                <p class="skill-text">
                    趣味を通して会話するイベントもあります。
                    <br> web共同開発からビアパーティまで
                    <br> 多くのイベントがあります。
                </p>
            </div>
        </div>
    </section>
    <section class="last-message">
        <div class="header-contents">
        <h1 class="site-title">あなたの街でレッスンをはじめよう</h1>
        <div class="buttons">
        <!--<div class="container">-->
                    <a class="FbBtn" href="login.php">
                        <div class="FbBtnLabel">Facebookではじめる </div>
                    </a>
        <!--</div>-->
        </div>
        </div>
    </section>
    <footer class="footer">
            <ul class="horizontal-list">
                <li class="horizontal-item"><a href="#">ABOUT US</a></li>
                <li class="horizontal-item"><a href="#">利用規約</a></li>
                <li class="horizontal-item"><a href="#">お問い合わせ</a></li>
            </ul>
            <p class="copyright">Copyright © 2016 Befriend</p>
        </footer>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="./jquery.bgswitcher.js"></script>
    <script>
        $(document).scroll(function() {    
        var scroll = $(window).scrollTop();

        if (scroll >= 1) {
            $("#gloval-header").removeClass("ex-gloval-header");
            $("#gloval-header").addClass("after-gloval-header");
        } else {
            $("#gloval-header").removeClass("after-gloval-header");
            $("#gloval-header").addClass("ex-gloval-header");
        }
        });
        
        
        $(document).ready(function(){
            $("#header_pc").bgswitcher({
                images: [
                    "./images/top_1.jpg",
                    "./images/top_2.jpg",
                    "./images/top_3.jpg",
                    "./images/top_4.jpg",
                    "./images/top_5.jpg"
                ],
                effect: "fade",
                easing: "swing",
                loop: true,
                interval: 5000
                });
            });




                
        
    </script>
    
</body>
</html>