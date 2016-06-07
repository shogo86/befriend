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

$sql = 'SELECT * FROM users WHERE fb_user_id = ?';
                $stmt = $dbh->prepare($sql);
                $data[] = $fb_user_id;
                $stmt->execute($data);
                
                //プロフィール情報の表示
                while(true)
                    {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if($rec==false)
                        {
                            break;
                        }
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
                    
                    
                    //画像が登録されていない場合は、登録されていない用の画像を表示
                    if(isset($picture_1))
                    {
                        $picture_1 = $picture_1;
                    } else {
                        $picture_1 = 'not_picture.jpeg';
                    }
                    
                    if(isset($picture_2))
                    {
                        $picture_2 = $picture_2;
                    } else {
                        $picture_2 = 'not_picture.jpeg';
                    }
                    
                    if(isset($picture_3))
                    {
                        $picture_3 = $picture_3;
                    } else {
                        $picture_3 = 'not_picture.jpeg';
                    }
                    
                    if(isset($picture_4))
                    {
                        $picture_4 = $picture_4;
                    } else {
                        $picture_4 = 'not_picture.jpeg';
                    }
                    
                    //画像の表記をfacebook取得か保存してある画像かの分岐
                    if(preg_match("/^http:/",$picture_1))
                    {
                        $picture_1 = $picture_1;
                    } else {
                        $picture_1 = '/picture/'.$picture_1;
                    }
                    
                    if(preg_match("/^http:/",$picture_2))
                    {
                        $picture_2 = $picture_2;
                    } else {
                        $picture_2 = '/picture/'.$picture_2;
                    }
                    
                    if(preg_match("/^http:/",$picture_3))
                    {
                        $picture_3 = $picture_3;
                    } else {
                        $picture_3 = '/picture/'.$picture_3;
                    }
                    
                    if(preg_match("/^http:/",$picture_4))
                    {
                        $picture_4 = $picture_4;
                    } else {
                        $picture_4 = '/picture/'.$picture_4;
                    }
                    
                    //値がNULLの場合は「選択してください」と表記する
                    if(isset($gender))
                    {
                        $gender = $gender;
                    } else {
                        $gender = '未入力';
                    }
                    
                    if(isset($age))
                    {
                        $age = $age;
                    } else {
                        $age = '未入力';
                    }
                    
                    if(isset($hometown))
                    {
                        $hometown = $hometown;
                    } else {
                        $hometown = '未入力';
                    }
                    
                    if(isset($location))
                    {
                        $location = $location;
                    } else {
                        $location = '未入力';
                    }
                    
                    if(isset($works))
                    {
                        $works = $works;
                    } else {
                        $works = '未入力';
                    }
                    
                    if(isset($college))
                    {
                        $college = $college;
                    } else {
                        $college = '未入力';
                    }
                    
                    if(isset($hobby))
                    {
                        $hobby = $hobby;
                    } else {
                        $hobby = '未入力';
                    }
                }
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
                    <li class="nav-item"><a href="user_list.php">ユーザー検索</a></li>
                    <li class="nav-item"><a href="event_list.php">イベント検索</a></li>
                    <!--<li class="nav-item"><a href="mypage.php"><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></a></li>-->
                </ul>
            </div>
            <div class="nav-profile">
            <p class="image"><a href="mypage.php"><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></a></p>
            <p class="name"><a href="mypage.php"><?= h($me->fb_name); ?></a></p>
            </div>
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
                
                <div class = "profile_picture">
                    <a href = "mypage_profile_picture.php" class = "profile_edit">写真編集</a>
                    <div>
                        <img src ="<?php print $picture_1; ?>" id="bigimg">
                    </div>
                    <ul>
                        <li><img src="<?php print $picture_1; ?>" class="thumb" data-image="<?php print $picture_1; ?>"></li>
                        <li><img src="<?php print $picture_2; ?>" class="thumb" data-image="<?php print $picture_2; ?>"></li>
                        <li><img src="<?php print $picture_3; ?>" class="thumb" data-image="<?php print $picture_3; ?>"></li>
                        <li><img src="<?php print $picture_4; ?>" class="thumb" data-image="<?php print $picture_4; ?>"></li>
                    </ul>
                    
                </div>
                
                <?php
                    print '<div class = "profile_text">';
                    print '<p class = "profile_title">プロフィール</p>';
                    print '<a href = "mypage_profile_edit.php" class = "profile_edit">編集</a>';
                    print '<p class = "desc">名前　　　　　　　　'.$fb_name.'</p>';
                    print '<p class = "desc">email　　　 　　　　'.$email.'</a></p>';
                    print '<p class = "desc">性別　　　　　　　　'.$gender_jp.'</p>';
                    print '<p class = "desc">年齢　　　　　　　　'.$age.'歳</p>';
                    print '<p class = "desc">得意な言語　　　　　'.$main_jp.'</p>';
                    print '<p class = "desc">学びたい言語　　　　'.$sub_jp.'</p>';
                    print '<p class = "desc">出身国　　　　　　　'.$hometown.'</p>';
                    print '<p class = "desc">所在地　　　　　　　'.$location.'</p>';
                    print '<p class = "desc">職業　　　　　　　　'.$works.'</p>';
                    print '<p class = "desc">大学　　　　　　　　'.$college.'</p>';
                    print '<p class = "desc">趣味　　　　　　　　'.$hobby.'</p>';
                    print '</div>';
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