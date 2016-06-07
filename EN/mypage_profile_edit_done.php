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

//SQLを使ってデータの追加
$sql='UPDATE users SET
      email=?,
      gender=?,
      age=?,
      main_language=?,
      sub_language=?,
      location=?,
      hometown=?,
      works=?,
      college=?,
      hobby=?
      WHERE fb_user_id=?';
$stmt=$dbh->prepare($sql);
$data[]=$email;
$data[]=$gender;
$data[]=$age;
$data[]=$main_language;
$data[]=$sub_language;
$data[]=$hometown;
$data[]=$location;
$data[]=$works;
$data[]=$college;
$data[]=$hobby;
$data[]=$fb_user_id;
$stmt->execute($data);
        
//DB接続を切断
$dbh=null;
        
header('Location: http://' . $_SERVER['HTTP_HOST']. '/mypage_profile.php');



?>