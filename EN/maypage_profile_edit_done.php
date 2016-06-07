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
/*
$gender = $_POST['gender'];
$age = $_POST['age'];
$main_language = $_POST['main_language'];
$sub_language = $_POST['sub_language'];
$hometown = $_POST['hometown'];
$location = $_POST['location'];
$works = $_POST['works'];
$college = $_POST['college'];
$hobby = $_POST['hobby'];
*/
?>