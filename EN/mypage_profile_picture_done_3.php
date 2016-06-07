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

$picture_3 = $_FILES['picture_3'];

//画像の拡張子の取得
$result = explode(".",$picture_3['name']);
$extension = $result[1];

//ファイル名の作成。facebook_id + マイクロタイム + 拡張子
$now = microtime(true);
$picture_edit = $fb_user_id.$now.'.'.$extension;

//画像をアップロード。
move_uploaded_file($picture_3['tmp_name'],'./picture/'.$picture_edit);

//データベースに保存
$sql='UPDATE users SET
      picture_3=?
      WHERE fb_user_id=?';
$stmt=$dbh->prepare($sql);
$data[]=$picture_edit;
$data[]=$fb_user_id;
$stmt->execute($data);
        
//DB接続を切断
$dbh=null;

header('Location: http://' . $_SERVER['HTTP_HOST']. '/mypage_profile.php');

?>