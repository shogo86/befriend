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

$sql ='SELECT * FROM users WHERE fb_user_id <> ?';

$stmt = $dbh->prepare($sql);
$data[] = $fb_user_id;


//SQLの実行
$stmt->execute($data);

$dbh = null;

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
                        $fb_other_id = $rec['fb_user_id'];
                        $fb_name = $rec['fb_name'];
                        $fb_link = $rec['fb_link'];
                        $email = $rec['email'];
                        $gender = $rec['gender'];
                        $age = $rec['age'];
                        $main_language = $rec['main_language'];
                        $sub_language = $rec['sub_language'];
                        $picture_1 = $rec['picture_1'];
                        $picture_2 = $rec['picture_2'];
                        $picture_3 = $rec['picture_3'];
                        $picture_4 = $rec['picture_4'];
                        $location = $rec['location'];
                        $hometown = $rec['hometown'];
                        $works = $rec['works'];
                        $college = $rec['college'];
                        $hobby = $rec['hobby'];
                        $introduction = $rec['introducton'];
                        
                        //言語を日本語表記に変換する
                        $main_jp=main($main_language);
                        $sub_jp=sub($sub_language);
                    
                        //性別を日本語表記にする
                        $gender_jp=gender($gender);
                        
                        //値がNULLの場合は「選択してください」と表記する
                        if(isset($gender))
                        {
                            $gender = $gender;
                        } else {
                            $gender = '';
                        }

                        if(isset($age))
                        {
                            $age = $age.'歳';
                        } else {
                            $age = '';
                        }

                        if(isset($hometown))
                        {
                            $hometown = $hometown;
                        } else {
                            $hometown = '';
                        }

                        if(isset($location))
                        {
                            $location = $location;
                        } else {
                            $location = '';
                        }

                        if(isset($works))
                        {
                            $works = $works;
                        } else {
                            $works = '';
                        }

                        if(isset($college))
                        {
                            $college = $college;
                        } else {
                            $college = '';
                        }

                        if(isset($hobby))
                        {
                            $hobby = $hobby;
                        } else {
                            $hobby = '';
                        }
                        
                        
                        print '<div class="article-box">';
                        print '<div class="profile">';
                        print '<a href =user_profile.php?fb_user_id='.$fb_other_id .'><img class="image" src="http://graph.facebook.com/'.$fb_other_id .'/picture?width=320&height=320"></a>';
                        print '<p class="desc">'.$fb_name.'</p>';
                        print '<p class="desc">'.$main_jp.' > '.$sub_jp. '</p>';
                        print '<p class="desc">'.$gender_jp.'</p>';
                        print '<p class="desc">'.$age.'</p>';
                        print '<p class="desc">'.$hometown.'</p>';
                        print '<p class="desc">'.$location.'</p>';
                        print '</div>';
                        print '</div>';
                        
                    
                        
                    }
                    
                    ?>

                </div>


            </main>
        </div>
        <footer class="footer">
            <ul class="horizontal-list">
                <li class="horizontal-item"><a href="#">ABOUT US</a></li>
                <li class="horizontal-item"><a href="#">利用規約</a></li>
                <li class="horizontal-item"><a href="#">CONTACT</a></li>
                <li class="horizontal-item"><a href="logout.php">ログアウト</a></li>
            </ul>
            <p class="copyright">Copyright © 2016 Befriend</p>
        </footer>
    </body>

    </html>