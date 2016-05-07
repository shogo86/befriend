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
$main = $_POST['main'];
$sub = $_POST['sub'];

//SQLを使ってデータの追加
$sql='UPDATE users SET
      main_language=?,
      sub_language=?
      WHERE fb_user_id=?';
$stmt=$dbh->prepare($sql);
$data[]=$main;
$data[]=$sub;
$data[]=$fb_user_id;
$stmt->execute($data);
        
//DB接続を切断
$dbh=null;
        
header('Location: http://' . $_SERVER['HTTP_HOST']. '/graduation/lesson_list.php');

?>