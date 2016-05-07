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

//main_languageが情報登録されているかチェック
$sql = 'SELECT main_language FROM users WHERE fb_user_id = ?';
$stmt = $dbh->prepare($sql);
$data[] = $fb_user_id;
$stmt->execute($data);

//DBの切断
$dbh = null;

//$stmtから1レコード取り出す
$rec = $stmt->fetch(PDO::FETCH_ASSOC);

//main_languageが登録されていたらレッスン一覧に飛ばす
if(isset($rec['main_language'])){
    header('Location: http://' . $_SERVER['HTTP_HOST']. '/graduation/lesson_list.php');
    //main_languageが登録されていなかったら登録画面を見せる
    } else {
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>BeFriends</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:700,400">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
  #container {
    width: 500px;
    margin: 0 auto;
  }
  #login {
    text-align: center;
    margin: 70px auto;
  }
  .btn {
    background: #3b5998;
    color: #fff;
    width: 200px;
    padding: 5px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
  }
  .btn:hover {
    opacity: 0.8;
  }
  #logout {
    text-align: right;
  }
  #profile {
    text-align: center;
  }
  h1 {
    font-size: 18px;
    margin: 0;
  }
  .pic {
    border-radius: 50%;
    margin-bottom: 10px;
  }
  p {
        margin: 0;  
    }  
  </style>
</head>

<body>
    <section class="contact" id="contact">
        <h2 class="heading">新規登録</h2>
        <p><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></p>
      <h1><a href="<?= h($me->fb_link); ?>"><?= h($me->fb_name); ?></a></h1>
      <p><?= h($userNode->getEmail()); ?></p>
        <p><?= h($me->fb_user_id); ?></p>
        <form class="contact-form" method="post" action="user_entry_done.php">
            <select name="main" required>
                <option value="">得意な言語を選択してください</option>
                <option value="1">日本語</option>
                <option value="2">英語</option>
                <option value="3">中国語</option>
            </select>
            <select name="sub" required>
                <option value="">学びたい言語を選択してください</option>
                <option value="1">日本語</option>
                <option value="2">英語</option>
                <option value="3">中国語</option>
            </select>
            <input type="submit" value="SEND">
        </form>
    </section>
    <footer class="footer">
        © sample site
    </footer>
    <script src="lib/placeholders.min.js"></script>
    
</body>
</html>
<?php } ?>