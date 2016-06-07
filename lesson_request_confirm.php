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
       users.gender,
       users.age,
       users.picture_1,
       users.picture_2,
       users.picture_3,
       users.picture_4,
       users.location,
       users.hometown,
       users.works,
       users.college,
       users.hobby,
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
            <div class="nav-profile">
            <p class="image"><a href="mypage.php"><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></a></p>
            <p class="name"><a href="mypage.php"><?= h($me->fb_name); ?></a></p>
            </div>
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
                        $gender = $rec['gender'];
                        $age = $rec['age'];
                        $picture_1 = $rec['picture_1'];
                        $picture_2 = $rec['picture_2'];
                        $picture_3 = $rec['picture_3'];
                        $picture_4 = $rec['picture_4'];
                        $location = $rec['location'];
                        $hometown = $rec['hometown'];
                        $main = $rec['main_language'];
                        $sub = $rec['sub_language'];
                        $works = $rec['works'];
                        $college = $rec['college'];
                        $hobby = $rec['hobby'];
                        
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
                        };
                        
                        //分が0の場合は00と表記する
                        if($time_end_minute == 0){
                            $time_end_minute = '00';
                        };
                        if($minute_change == 0){
                            $minute_change = '00';
                        };
                        
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
                        
                        
                        
                        
                        
                        
                        
                        
                        

                        /*
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
                        
                    */
                        
                    }
                    ?>
                    <div class = "profile_picture">
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
                    print '<div class = "lesson_text">';
                    print '<p class = "profile_title">レッスン情報</p>';
                    print '<p class = "desc">日時　　　　　　　　'.$date.'（'.$week[$w].'）'.'</p>';
                    print '<p class = "desc">時間　　　　　　　　'.$hour.'時'.$minute_change.'分'.' 〜 '.$time_end_hour.'時'.$time_end_minute.'分'.'</p>';
                    print '<p class = "desc">都道府県　　　　　　'.$state_jp.'</p>';
                    print '<p class = "desc">詳細な場所　　　　　'.$street.'</p>';
                    print '</div>';
                    
                    print '<div class = "profile_text_lesson">';
                    print '<p class = "profile_title">プロフィール</p>';
                    print '<p class = "desc">名前　　　　　　　　'.$entry_user_name.'</p>';
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
                    print "<a class='submit_button' href='lesson_request_done.php?lesson_entry_id={$lesson_entry_id}&lesson_entry_fbuserid={$lesson_entry_fbuserid}'>リクエストを送る</a>";
                    print '</div>';
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"> 
        </script>
        <script>
        var thumbs = document.querySelectorAll('.thumb');
        for(var i = 0; i < thumbs.length; i++) {
	       thumbs[i].onclick = function() {
		      document.getElementById('bigimg').src = this.dataset.image;
	   };
        }
            
        $(function(){
        var setFileInput = $('.img_input');
 
        setFileInput.each(function(){
        var selfFile = $(this),
        selfInput = $(this).find('input[type=file]');
 
        selfInput.change(function(){
        var file = $(this).prop('files')[0],
        fileRdr = new FileReader(),
        selfImg = selfFile.find('.imgView');
 
        if(!this.files.length){
            if(0 < selfImg.size()){
                   selfImg.remove();
                return;
            }
        } else {
            if(file.type.match('image.*')){
                if(!(0 < selfImg.size())){
                    selfFile.append('<img alt="" class="imgView">');
                }
                var prevElm = selfFile.find('.imgView');
                fileRdr.onload = function() {
                        prevElm.attr('src', fileRdr.result);
                    }
                    fileRdr.readAsDataURL(file);
                } else {
                    if(0 < selfImg.size()){
                        selfImg.remove();
                        return;
                        }
                    }
                }
            });
        });
        });
            
        </script>
        
    </body>

    </html>