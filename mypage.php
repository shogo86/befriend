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
                <!--
                <div class="mypage_table">
                    <p>レッスンを承認する</p>
                    <p>参加予定のレッスン</p>
                    <p>参加済みのレッスン</p>
                    <p>登録済みのレッスン</p>
                    <p>メッセージ</p>
                    <p>プロフィール</p>
                </div>
                -->
                
                <ul class = "mypage_gnav">
                    <li><a href="mypage.php">レッスンを承認する</a></li>
                    <li><a href="mypage_lesson_plans.php">参加予定のレッスン</a></li>
                    <li><a href="mypage_lesson_past.php">参加済みのレッスン</a></li>
                    <li><a href="mypage_lesson_all.php">登録済みのレッスン</a></li>
                    <li><a href="">メッセージ</a></li>
                    <li><a href="mypage_profile.php">プロフィール</a></li>
                </ul>
                
                <div class="mypage_lesson">
                <?php
                //自分の登録したレッスンの抽出
                /*$sql = 'SELECT 
                            id,
                            day,
                            time,
                            state,
                            city,
                            street,
                            detail        
                        FROM 
                            lesson_entry
                        WHERE 
                            fb_user_id = ?
                ';
                $stmt = $dbh->prepare($sql);
                $data[] = $fb_user_id;
                $stmt->execute($data);
                */
                
                $sql = 'SELECT 
                            lesson_join.id,
                            lesson_join.lesson_entry_id,
                            lesson_join.fb_user_id,
                            lesson_entry.day,
                            lesson_entry.hour,
                            lesson_entry.minute,
                            lesson_entry.time,
                            lesson_entry.state,
                            lesson_entry.city,
                            lesson_entry.street,
                            lesson_entry.detail,
                            users.fb_name,
                            users.main_language,
                            users.sub_language
                        FROM 
                            lesson_entry
                        LEFT JOIN
                            lesson_join
                        ON
                            lesson_entry.id = lesson_join.lesson_entry_id
                        LEFT JOIN
                            users
                        ON
                            lesson_join.fb_user_id = users.fb_user_id
                        WHERE 
                            lesson_entry.fb_user_id = ?
                            AND lesson_join.matching IS NULL
                            AND users.fb_user_id <> ?
                            AND lesson_entry.day >= NOW()
                        ORDER BY lesson_entry.id
                        
                ';
                $stmt = $dbh->prepare($sql);
                $data[] = $fb_user_id;
                $data[] = $fb_user_id;
                $stmt->execute($data);
                
                
                
                //レッスン情報の表示
                while(true)
                    {
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if($rec==false)
                        {
                            break;
                        }
                    $lesson_join_id = $rec['id'];
                    $lesson_entry_id = $rec['lesson_entry_id'];
                    $lesson_join_fbuserid = $rec['fb_user_id'];
                    $day = $rec['day'];
                    $hour = $rec['hour'];
                    $minute = $rec['minute'];
                    $time = $rec['time'];
                    $state = $rec['state'];
                    $city = $rec['city'];
                    $street = $rec['street'];
                    $detail = $rec['detail'];
                    $entry_user_name = $rec['fb_name'];
                    $main = $rec['main_language'];
                    $sub = $rec['sub_language'];
                    
                    $minute_change=minute($minute);
                        $time_change=time_change($time);
                        $main_jp=main($main);
                        $sub_jp=sub($sub);
                        $state_jp=state_jp($state);
                        
                        //日付のみに変換する
                        $date = substr($day,0,10);
                        //曜日の抽出
                        $datetime = new DateTime($date);
                        $week = array("日", "月", "火", "水", "木", "金", "土");
                        $w = (int)$datetime->format('w');
                        
                        //終了時間の算出
                        $time_count = ($hour * 60 + $minute_change + $time_change) / 60;
                        
                        $time_end = explode('.',$time_count);
                        //終了の時
                        $time_end_hour = $time_end[0];
                        //終了の分の計算
                        if($time_end[1] < 10){
                            $time_end_minute = $time_end[1] * 0.1 * 60;
                        } else {
                            $time_end_minute = $time_end[1] * 0.01 * 60;
                        };
                        
                        //分が0の場合は00と表記する
                        if($time_end_minute == 0){
                            $time_end_minute = '00';
                        };
                        if($minute_change == 0){
                            $minute_change = '00';
                        };
                        
                        print '<div class="article-box">';
                        print '<div class="profile">';
                        print '<img class="image" src="http://graph.facebook.com/'.$lesson_join_fbuserid.'/picture?width=320&height=320">';
                        print '<p class="desc">'.$entry_user_name.'</p>';
                        print '<p class="desc">'.$main_jp.' > '.$sub_jp. '</p>';
                        print '</div>';
                        print '<div class="time">';
                        print '<p class="desc">'.$date.'（'.$week[$w].'）'.'</p>';
                        print '<p class="desc">'.$hour.'時'.$minute_change.'分'.' 〜 '.$time_end_hour.'時'.$time_end_minute.'分'.'</p>';
                        print '</div>';
                        print '<div class="place">';
                        print '<p class="desc">'.$state_jp.'</p>';
                        print '<p class="desc">'.$street.'</p>';
                        print '</div>';
                        print "<a class='btn' href='lesson_join_agree_done.php?lesson_join_id={$lesson_join_id}&lesson_join_fbuserid={$lesson_join_fbuserid}&lesson_entry_id={$lesson_entry_id}'>リクエストを承認</a>";
                        print '</div>';
                    
                    
                    
                    /*$day = $rec['day'];
                    $time = $rec['time'];
                    $state = $rec['state'];
                    $city = $rec['city'];
                    $street = $rec['street'];
                    $detail = $rec['detail'];*/
                }
                    /*
                    //DB接続をする
                    $dsn='mysql:dbname=befriend;host=localhost;';
                    $user='dbuser';
                    $password='shogo0141';
                    $dbh=new PDO($dsn,$user,$password);
                    $dbh->query('SET NAMES utf8');
                    
                    
                    //レッスンに紐づくユーザー情報の抽出
                    $sql_users = 'SELECT 
                                    lesson_join.id,
                                    users.fb_name 
                                FROM 
                                    lesson_join 
                                LEFT JOIN 
                                    users 
                                ON 
                                    lesson_join.fb_user_id = users.fb_user_id 
                                WHERE 
                                    lesson_join.lesson_entry_id = ? ';
                    
                    $stmt_users = $dbh->prepare($sql_users);
                    $data_users[] = $lesson_entry_id;
                    $stmt->execute($data);
                    $dbh = null;
                    */
                    /*
                    print '<tr>';
                        print '<th>日付</th>';
                        print '<td>'.$day.'</td>';
                    print '</tr>';
                    print '<tr>';
                        print '<th>時間</th>';
                        print '<td>'.$time.'</td>';
                    print '</tr>';
                    
                    }*/
                
                    
                    
                    
                    /*
                    print '<div class="article-box">';  
                    print '<p class="desc">'.$day.'</p>';
                    print '<p class="desc">'.'レッスン時間：'.$time.'</p>';
                    print '<p class="desc">'.'場所：'.$street.'</p>';
                    print '<br />';
                    print '<br />';
                    print '</div>';
                    */
                    
                    
                    //var_dump($lesson_entry_id );
                    //exit;
                    
                    /*
                    
                    //DB接続をする
                    $dsn='mysql:dbname=befriend;host=localhost;';
                    $user='dbuser';
                    $password='shogo0141';
                    $dbh=new PDO($dsn,$user,$password);
                    $dbh->query('SET NAMES utf8');
                    
                    //SQLの作成
                    $sql_users = 'SELECT lesson_join.id,users.fb_name FROM lesson_join LEFT JOIN users ON lesson_join.fb_user_id = users.fb_user_id WHERE lesson_join.lesson_entry_id = ? ';
                    $stmt_users = $dbh->prepare($sql_users);
                    $data_users[] = $lesson_entry_id;
                    //var_dump($data_users);
                    //exit;
                    $stmt_users->execute($data_users);

                    //DBの切断
                    $dbh = null;
                    
                    while(true)
                    {
                        $rec_users = $stmt_users->fetch(PDO::FETCH_ASSOC);
                        
                        if($rec==false)
                        {
                            break;
                        }
                    $user_fb_name = $rec_users['fb_name'];
                        //var_dump($user_fb_name);
                        //exit;
                    
                    
                    
                    
                    while(true)
                    {
                        $rec_users = $stmt_users->fetch(PDO::FETCH_ASSOC);
                        
                        if($rec_users==false)
                        {
                            break;
                        }


                        $user_name = $rec['users.fb_name'];
                        var_dump($user_name);
                        exit;
                    
                        
                    }
                }*/
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