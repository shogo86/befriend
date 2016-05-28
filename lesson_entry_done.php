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

//データの受け取り
$day=$_POST['day'];
$hour=$_POST['hour'];
$minute=$_POST['minute'];
$time=$_POST['time'];
$state=$_POST['state'];
$city=$_POST['city'];
$street=$_POST['street'];
$detail=$_POST['detail'];


//SQLを使ってデータの追加
$sql='INSERT INTO lesson_entry (fb_user_id,day,hour,minute,time,state,city,street,detail) VALUES (?,?,?,?,?,?,?,?,?)';
$stmt=$dbh->prepare($sql);
$data[]=$fb_user_id;
$data[]=$day;
$data[]=$hour;
$data[]=$minute;
$data[]=$time;
$data[]=$state;
$data[]=$city;
$data[]=$street;
$data[]=$detail;

$stmt->execute($data);
        
//DB接続を切断
$dbh=null;

//レッスン一覧へ飛ばす
goLessonlist();

    ?>