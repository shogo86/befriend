<?php
session_start();
session_regenerate_id();
$id=$_SESSION['id'];
$main=$_SESSION['main'];
$sub=$_SESSION['sub'];

$lesson_id=$_GET['lesson_id'];
$request_user_id=$_GET['request_user_id'];
$request_lesson_id=$_GET['request_lesson_id'];


//自作関数の読み込み
require_once('function/function.php');

if(isset($_SESSION['login'])==false)
{
    print 'ログインされていません。　<br />';
    print '<a href="toppage.php">ログイン画面へ</a>';
    exit();
}
else
{
    print 'ようこそ';
    print $_SESSION['name'];
    print '様';
}

//2. DB文字コードを指定（固定）
$stmt = $pdo->query('SET NAMES utf8');


//３．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM lesson WHERE id=$lesson_id");

//４．SQL実行
$flag = $stmt->execute();

//5.表示文字列を作成→変数に追記で代入

?>


    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>レッスンを探す</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/lesson_list.css">
    </head>

    <body>

        <header class="header">
            <nav class="global-nav">
                <ul>
                    <li class="nav-item active"><a href="lesson_list.php">LESSON一覧</a></li>
                    <li class="nav-item"><a href="lesson_entry.php">LESSON登録</a></li>
                    <li class="nav-item"><a href="#">イベント検索</a></li>
                    <li class="nav-item"><a href="mypage.php">MYPAGE</a></li>
                </ul>
            </nav>
        </header>
        <div class="wrapper clearfix">
            <main class="main">
                <h2 class="hidden">ARTICLES</h2>
                <div class="clearfix">
                    <?php
                    //レッスンリストの一覧の作成
                    while(true)
                    {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($result==false)
                    {
                    break;
                    }
                    $title=$result['title'];
                    $start=$result['start_time'];
                    $time=$result['time'];
                    $time_jp=jikan($time);
                    $userid=$result['user_id'];
                        
                        //2. DB文字コードを指定（固定）
                        $stmt_user = $pdo->query('SET NAMES utf8');

                        //３．データ登録SQL作成
                        $stmt_user = $pdo->prepare("SELECT * FROM user WHERE id=$request_user_id");

                        //４．SQL実行
                        $flag = $stmt_user->execute();
                        
                        $result_user=$stmt_user->fetch(PDO::FETCH_ASSOC);
                        $name=$result_user['name'];
                        $main=$result_user['main_language'];
                        $sub=$result_user['sub_language'];
                        $picture=$result_user['picture'];
                        $main_jp=main($main);
                        $sub_jp=sub($sub);
    
                        print '<div class="article-box">';
                        print '<img class="image" src="./picture/'.$picture.'">';
                        print '<h3 class="title">'.$name.'</h3>';
                        print '<p class="desc">'.'得意な言語：'.$main_jp.'</p>';
                        print '<p class="desc">'.'学びたい言語：'.$sub_jp.'</p>';   
                        print '<p class="desc">'.$start.'</p>';
                        print '<p class="desc">'.'レッスン時間：'.$time_jp.'</p>';
                        print '<br />';
                        
                        //OKボタンを押したらマッチングフラグの登録を行う
                        print '<form method="post" action="lesson_request_approval_done.php">';
                        print '<input type="hidden" name="matching" value="1">';
                        print '<input type="hidden" name="request_lesson_id" value="'.$request_lesson_id.'">';
                        print '<input type="submit" value="リクエスト承認する">';
                        print '</form>';
                        print '<br />';
                        print '<br>';
                        //NGボタンを押したらマッチングフラグの拒否を行う
                        print '<form method="post" action="lesson_request_approval_done.php">';
                        print '<input type="hidden" name="matching" value="2">';
                        print '<input type="hidden" name="request_lesson_id" value="'.$request_lesson_id.'">';
                        print '<input type="submit" value="リクエストを拒否する">';
                        print '</form>';
                        print '</div>';
                        
                    }
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
    </body>

    </html>