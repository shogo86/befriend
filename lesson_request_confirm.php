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

$lesson_entry_id = $_GET['lesson_entry_id'];
$lesson_entry_fbuserid = $_GET['lesson_entry_fbuserid'];

//レッスン情報、ユーザー情報の抽出

$sql ='SELECT
       lesson_entry.id,
       lesson_entry.fb_user_id,
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
       users
     ON
       lesson_entry.fb_user_id = users.fb_user_id
     WHERE
       lesson_entry.id = ?
     ';

$stmt = $dbh->prepare($sql);
$data[] = $lesson_entry_id;

//SQLの実行
$stmt->execute($data);

$dbh = null;




?>


    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
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
                    <li class="nav-item"><a href="#">イベント検索</a></li>
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
                        $lesson_entry_id = $rec['id'];
                        $lesson_entry_fbuserid = $rec['fb_user_id'];
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
                        print '<a href =user_profile.php?fb_user_id='.$lesson_entry_fbuserid.'><img class="image" src="http://graph.facebook.com/'.$lesson_entry_fbuserid.'/picture?width=320&height=320"></a>';
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
                        print "<a class='btn' href='lesson_request_done.php?lesson_entry_id={$lesson_entry_id}&lesson_entry_fbuserid={$lesson_entry_fbuserid}'>リクエストを送る</a>";
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
                <li class="horizontal-item"><a href="#">SNS</a></li>
                <li class="horizontal-item"><a href="#">CONTACT</a></li>
            </ul>
            <p class="copyright">Copyright © 2015 SAMPLE SITE</p>
        </footer>
    </body>

    </html>