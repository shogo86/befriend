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

$email = $_POST['email'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$main_language = $_POST['main_language'];
$sub_language = $_POST['sub_language'];
$hometown = $_POST['hometown'];
$location = $_POST['location'];
$works = $_POST['works'];
$college = $_POST['college'];
$hobby = $_POST['hobby'];

//言語を日本語表記に変換する
$main_jp=main($main_language);
$sub_jp=sub($sub_language);

//性別を日本語表記にする
$gender_jp=gender($gender);


?>


    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>レッスンを探す</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/lesson_list.css">
        <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    </head>

    <body>

        <header id="header">
            <div class="global-nav">
                <ul>
                    <li class="nav-item active"><a href="lesson_list.php">LESSON一覧</a></li>
                    <li class="nav-item"><a href="#">ユーザー検索</a></li>
                    <li class="nav-item"><a href="#">イベント検索</a></li>
                    <!--<li class="nav-item"><a href="mypage.php"><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></a></li>-->
                </ul>
            </div>
            <p class="image"><a href="mypage.php"><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></a></p>
            <p class="name"><a href="mypage.php"><?= h($me->fb_name); ?></a></p>
            <p class="lesson_entry"><a href="lesson_entry.php">レッスン登録</a></p>
            <p class="befriend"><a href="lesson_list.php">Befriend</a></p>
        </header>
        
        
        <div class="wrapper clearfix">
            <main class="main">
                <ul class = "mypage_gnav">
                    <li><a href="mypage.php">レッスンを承認する</a></li>
                    <li><a href="mypage_lesson_plans.php">参加予定のレッスン</a></li>
                    <li><a href="mypage_lesson_past.php">参加済みのレッスン</a></li>
                    <li><a href="mypage_lesson_all.php">登録済みのレッスン</a></li>
                    <li><a href="">メッセージ</a></li>
                    <li><a href="mypage_profile.php">プロフィール</a></li>
                </ul>
                
                
                <?php
                
                print '<div class = "profile_text">';
                print '<p class = "profile_title">プロフィール更新確認</p>';
                print '<p class = "desc">email　　　 　　　　'.$email.'</p>';
                print '<p class = "desc">性別　　　　　　　　'.$gender_jp.'</p>';
                print '<p class = "desc">年齢　　　　　　　　'.$age.'歳</p>';
                print '<p class = "desc">得意な言語　　　　　'.$main_jp.'</p>';
                print '<p class = "desc">学びたい言語　　　　'.$sub_jp.'</p>';
                print '<p class = "desc">出身国　　　　　　　'.$hometown.'</p>';
                print '<p class = "desc">所在地　　　　　　　'.$location.'</p>';
                print '<p class = "desc">職業　　　　　　　　'.$works.'</p>';
                print '<p class = "desc">大学　　　　　　　　'.$college.'</p>';
                print '<p class = "desc">趣味　　　　　　　　'.$hobby.'</p>';
                
                
                print '<form action="mypage_profile_edit_done.php" method="post">';
                print '<input type="hidden" name="email" value='.$email.'>';
                print '<input type="hidden" name="gender" value='.$gender.'>';
                print '<input type="hidden" name="age" value='.$age.'>';
                print '<input type="hidden" name="main_language" value='.$main_language.'>';
                print '<input type="hidden" name="sub_language" value='.$sub_language.'>';
                print '<input type="hidden" name="hometown" value='.$hometown.'>';
                print '<input type="hidden" name="location" value='.$location.'>';
                print '<input type="hidden" name="works" value='.$works.'>';
                print '<input type="hidden" name="college" value='.$college.'>';
                print '<input type="hidden" name="hobby" value='.$hobby.'>';
                print '<input type="submit" value="この内容で更新する">';
                print '</form>';
                
                print '</div>';
                
                /*
                print '<div class = "profile_text">';
                print '<p class = "profile_title">プロフィール</p>';
                print '<form action = "mypage_profile_confirm.php" method = "post">';
                print '<p class = "desc">メールアドレス</p>';
                print '<input type = "text"  name = "email" value = '.$email.' >';
                print '<p class = "desc">性別</p>';
                print '<select name="gender" value='.$gender.'>';
                print '<option value="1">男性</option>';
                print '<option value="2">女性</option>';
                print '</select>';
                print '<p class = "desc">年齢</p>';
                print '<input type = "number"  name = "age" value = '.$age.' >';
                print '<p class = "desc">得意な言語</p>';
                print '<select name="main_language" value='.$main_language.'>';
                print '<option value="1">日本語</option>';
                print '<option value="2">英語</option>';
                print '<option value="3">中国語</option>';
                print '</select>';
                print '<p class = "desc">学びたい言語</p>';
                print '<select name="main_language" value='.$sub_language.'>';
                print '<option value="1">日本語</option>';
                print '<option value="2">英語</option>';
                print '<option value="3">中国語</option>';
                print '</select>';
                print '<p class = "desc">出身国</p>';
                print '<input type = "text"  name = "hometown" value = '.$hometown.' >';
                print '<p class = "desc">所在国</p>';
                print '<input type = "text"  name = "location" value = '.$location.' >';
                print '<p class = "desc">大学</p>';
                print '<input type = "text"  name = "college" value = '.$college.' >';
                print '<p class = "desc">趣味</p>';
                print '<input type = "text"  name = "hobby" value = '.$hobby.' >';
                print '</form>';
                print '<input type="submit" value="更新する"></p>';
                print '</div>';
                */
                
                
                ?>
            
                 </main>
        </div>

        <footer class="footer">
            <ul class="horizontal-list">
                <li class="horizontal-item"><a href="#">ABOUT ME</a></li>
                <li class="horizontal-item"><a href="#">SITE MAP</a></li>
                <li class="horizontal-item"><a href="#">CONTACT</a></li>
                <li class="horizontal-item"><a href="logout.php">ログアウト</a></li>
            </ul>
            <p class="copyright">Copyright © 2015 SAMPLE SITE</p>
        </footer>
        <script>
        var thumbs = document.querySelectorAll('.thumb');
        for(var i = 0; i < thumbs.length; i++) {
	       thumbs[i].onclick = function() {
		      document.getElementById('bigimg').src = this.dataset.image;
	   };
        }
        </script>
    </body>

    </html>