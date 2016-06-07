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
$lesson_entry_id=$_GET['lesson_entry_id'];


//SQLを使ってデータの追加
$sql='DELETE FROM lesson_entry WHERE id = ?';
$stmt=$dbh->prepare($sql);
$data[]=$lesson_entry_id;

$stmt->execute($data);
        
//DB接続を切断
$dbh=null;

//プロフィールページの自分の登録したレッスン一覧へ飛ばす
header('Location: http://' . $_SERVER['HTTP_HOST']. '/mypage_lesson_all.php');

    ?>