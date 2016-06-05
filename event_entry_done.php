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
$title=$_POST['title'];
$picture=$_FILES['picture'];
$persons=$_POST['persons'];
$day=$_POST['day'];
$hour=$_POST['hour'];
$minute=$_POST['minute'];
$time=$_POST['time'];
$state=$_POST['state'];
$street=$_POST['street'];
$detail=$_POST['detail'];

//画像の拡張子の取得
$result = explode(".",$picture['name']);
$extension = $result[1];

//ファイル名の作成。facebook_id + マイクロタイム + 拡張子
$now = microtime(true);
$picture_edit = $fb_user_id.$now.'.'.$extension;

//画像をアップロード。
move_uploaded_file($picture['tmp_name'],'./picture/'.$picture_edit);


//SQLを使ってデータの追加
$sql='INSERT INTO event_entry (fb_user_id,title,picture_1,persons,day,hour,minute,time,state,street,detail) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
$stmt=$dbh->prepare($sql);
$data[]=$fb_user_id;
$data[]=$title;
$data[]=$picture_edit;
$data[]=$persons;
$data[]=$day;
$data[]=$hour;
$data[]=$minute;
$data[]=$time;
$data[]=$state;
$data[]=$street;
$data[]=$detail;

$stmt->execute($data);
        
//DB接続を切断
$dbh=null;



//プロフィールページの自分の登録したイベント一覧へ飛ばす
header('Location: http://' . $_SERVER['HTTP_HOST']. '/mypage_lesson_all.php');

    ?>