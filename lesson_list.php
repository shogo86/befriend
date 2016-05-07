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

$sql ='SELECT 
       lesson_entry.fb_user_id,
       lesson_entry.day,
       lesson_entry.time,
       lesson_entry.state,
       lesson_entry.city,
       lesson_entry.street,
       lesson_entry.detail,
       users.main_language,
       users.sub_language
     FROM 
       lesson_entry
     LEFT JOIN
       users
     ON
       lesson_entry.fb_user_id = users.fb_user_id
     ';

$stmt = $dbh->prepare($sql);

//SQLの実行
$stmt->execute();

$dbh = null;

?>


    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>レッスンを探す</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/lesson_list.css">
    </head>

    <body>

        <header class="header">
            <nav class="global-nav">
                <ul>
                    <li class="nav-item active"><a href="lesson_list.php">LESSON一覧</a></li>
                    <li class="nav-item"><a href="lesson_entry.php">LESSON登録</a></li>
                    <li class="nav-item"><a href="#">イベント検索</a></li>
                    <li class="nav-item"><a href="mypage.php">MYPAGE</a></li>
                </ul>
            </nav>
        </header>
        <div class="wrapper clearfix">
            <main class="main">
                <h2 class="hidden">ARTICLES</h2>
                <div class="clearfix">
                    
                    <?php
                    
                    while(true)
                    {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if($rec==false)
                        {
                            break;
                        }
                    $fb_user_id = $rec['fb_user_id'];
                    $day = $rec['day'];
                    $time = $rec['time'];
                    $state = $rec['state'];
                    $city = $rec['city'];
                    $street = $rec['street'];
                    $detail = $rec['detail'];
                    $main = $rec['main_language'];
                    $sub = $rec['sub_language'];
                    
                        print '<div class="article-box">';
                        print '<img class="image" src="http://graph.facebook.com/'. h($me->fb_user_id).'/picture">';
                        print '<p class="desc">'.h($me->fb_name).'</p>';
                        print '<p class="desc">'.'得意な言語：'.$main.'</p>';
                        print '<p class="desc">'.'学びたい言語：'.$sub.'</p>';   
                        print '<p class="desc">'.$day.'</p>';
                        print '<p class="desc">'.'レッスン時間：'.$time.'</p>';
                        print '<p class="desc">'.'場所：'.$street.'</p>';
                        print '<br />';
                        print '<br />';
                        print "<a class='btn' href=''>参加する</a>";
                        print '</div>';
                        
                    
                        
                    }
                    
                    ?>

                </div>


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
    </body>

    </html>