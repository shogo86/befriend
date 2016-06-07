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
$lesson_join_id = $_GET['lesson_join_id'];
$lesson_join_fbuserid = $_GET['lesson_join_fbuserid'];
$lesson_entry_id = $_GET['lesson_entry_id'];

//SQLを使ってマッチングしたデータの追加
//$sql_join = 'UPDATE lesson_join SET matching = 1 WHERE id = ?';
$sql_join = 'UPDATE lesson_join SET matching = CASE WHEN id = ? THEN 1 WHEN id <> ? AND lesson_entry_id = ? THEN 0 ELSE matching END';
$stmt=$dbh->prepare($sql_join);
$data[]=$lesson_join_id;
$data[]=$lesson_join_id;
$data[]=$lesson_entry_id;
$stmt->execute($data);

//DB接続を切断
$dbh=null;

//レッスン一覧へ飛ばす
header('Location: http://' . $_SERVER['HTTP_HOST']. '/mypage.php');

    ?>