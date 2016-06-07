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
       event_entry.id,
       event_entry.fb_user_id,
       event_entry.title,
       event_entry.picture_1,
       event_entry.persons,
       event_entry.day,
       event_entry.hour,
       event_entry.minute,
       event_entry.time,
       event_entry.state,
       event_entry.city,
       event_entry.street,
       event_entry.detail,
       users.fb_name,
       users.main_language,
       users.sub_language
     FROM 
       event_entry
     LEFT JOIN
       users
     ON
       event_entry.fb_user_id = users.fb_user_id
     WHERE event_entry.fb_user_id <> ?
     AND event_entry.day >= NOW()
     ORDER BY event_entry.day
     ';

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
                    <li class="nav-item"><a href="event_list.php">イベント検索</a></li>
                </ul>
            </div>
            <div class="nav-profile">
            <p class="image"><a href="mypage.php"><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></a></p>
            <p class="name"><a href="mypage.php"><?= h($me->fb_name); ?></a></p>
            </div>
            <p class="lesson_entry"><a href="event_entry.php">イベント登録</a></p>
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
                        $event_entry_id = $rec['id'];
                        $event_entry_fbuserid = $rec['fb_user_id'];
                        $title = $rec['title'];
                        $picture = $rec['picture_1'];
                        $persons = $rec['persons'];
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
                        //終了の分の計算。小数点が存在する場合に分数に置き換える
                        if(isset($time_end[1])){
                        if($time_end[1] < 10){
                            $time_end_minute = $time_end[1] * 0.1 * 60;
                        } else {
                            $time_end_minute = $time_end[1] * 0.01 * 60;
                        }} else {
                            //小数点が存在しない場合は00とする
                            $time_end_minute = '00';
                        }
                            ;
                        
                        //分が0の場合は00と表記する
                        if($time_end_minute == 0){
                            $time_end_minute = '00';
                        };
                        if($minute_change == 0){
                            $minute_change = '00';
                        };
                        
                        
                        print '<div class="article-box">';
                        print '<div class="profile">';
                        print '<a href =""><img class="event_image" src="./picture/'.$picture.'"></a>';
                        print '<p class="desc_title">'.$title.'</p>';
                        print '<p class="desc_persons">'.$persons.'人</p>';
                        print '</div>';
                        print '<div class="event_time">';
                        print '<p class="desc">'.$date.'（'.$week[$w].'）'.'</p>';
                        print '<p class="desc">'.$hour.'時'.$minute_change.'分'.' 〜 '.$time_end_hour.'時'.$time_end_minute.'分'.'</p>';
                        print '</div>';
                        print '<div class="place">';
                        print '<p class="desc">'.$state_jp.'</p>';
                        print '<p class="desc">'.$street.'</p>';
                        print '</div>';
                        print "<a class='btn' href='event_request_confirm.php?event_entry_id={$event_entry_id}&event_entry_fbuserid={$event_entry_fbuserid}'>参加する</a>";
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