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

?>


    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>マイページ</title>
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
                <h2>レッスン情報</h2>
                <?php
                /*
                
                //レッスン情報
                while($result_lesson = $stmt_lesson->fetch(PDO::FETCH_ASSOC)){
                        $lesson_id=$result_lesson['id'];
                        $lesson_title=$result_lesson['title'];
                        $lesson_start=$result_lesson['start_time'];
                        $lesson_time=$result_lesson['time'];
                        $lesson_time_jp=jikan($lesson_time);
                        $lesson_location=$result_lesson['location'];
                        $lesson_detail=$result_lesson['detail'];
                    
                //レッスンリクエスト
                    //DB文字コードを指定（固定）
                    $stmt_lesson_request = $pdo->query('SET NAMES utf8');

                    //データ登録SQL作成
                    $stmt_lesson_request = $pdo->prepare("SELECT * FROM lesson_request WHERE lesson_id=$lesson_id");

                    //SQL実行
                    $flag_lesson_request = $stmt_lesson_request->execute();

                    //自分のレッスンへリクエストしている人
                    $result_lesson_request = $stmt_lesson_request->fetch(PDO::FETCH_ASSOC);
                    $request_lesson_id=$result_lesson_request['id'];
                    $request_user_id=$result_lesson_request['request_user_id'];
                    
                    //マッチングフラグ
                    $matching = $result_lesson_request['matching'];
                    
                //レッスンリクエストのユーザー情報抽出
                    //DB文字コードを指定（固定）
                    $stmt_request_user = $pdo->query('SET NAMES utf8');

                    //データ登録SQL作成
                    $stmt_request_user = $pdo->prepare("SELECT * FROM user WHERE id=$request_user_id");

                    //SQL実行
                    $flag_request_user = $stmt_request_user->execute();
                    
                    //ユーザー情報の抽出
                    $result_request_user = $stmt_request_user->fetch(PDO::FETCH_ASSOC);
                    $request_user_name = $result_request_user['name'];
                    $request_user_picture = $result_request_user['picture'];
                    
                    //マッチングしているレッスン情報の表示
                    if($matching==1)
                    {
                        print '<div class="article-box-mylesson">';
                        print '<p class="desc">'.'タイトル：'.$lesson_title.'</p>';
                        print '<p class="desc">'.'開始時間：'.$lesson_start.'</p>';
                        print '<p class="desc">'.'レッスン時間：'.$lesson_time_jp.'</p>';
                        print '<p class="desc">'.'場所：'.$lesson_location.'</p>';
                        print '<p class="desc">'.'詳細：'.$lesson_detail.'</p>';
                        print '<img class="image" src="./picture/'.$request_user_picture.'">';
                        print '<p class="text_matching">参加予定</p>';
                        print '</div>';
                    }else{
                    //マッチングしていないレッスン情報の表示
                        //リクエストしている人がいない場合
                        
                     if(isset($request_user_id)==false)
                    {
                        print '<div class="article-box-mylesson">';
                        print '<p class="desc">'.'タイトル：'.$lesson_title.'</p>';
                        print '<p class="desc">'.'開始時間：'.$lesson_start.'</p>';
                        print '<p class="desc">'.'レッスン時間：'.$lesson_time_jp.'</p>';
                        print '<p class="desc">'.'場所：'.$lesson_location.'</p>';
                        print '<p class="desc">'.'詳細：'.$lesson_detail.'</p>';
                        print '<p class="text_no_matching">リクエスト待ち</p>';
                        print '</div>';
                    }
                    else
                        //リクエストしている人がいる場合
                    {
                        print '<div class="article-box-mylesson">';
                        print '<p class="desc">'.'タイトル：'.$lesson_title.'</p>';
                        print '<p class="desc">'.'開始時間：'.$lesson_start.'</p>';
                        print '<p class="desc">'.'レッスン時間：'.$lesson_time_jp.'</p>';
                        print '<p class="desc">'.'場所：'.$lesson_location.'</p>';
                        print '<p class="desc">'.'詳細：'.$lesson_detail.'</p>';
                        print '<p class="desc">リクエストしている人</p>';
                        print "<a href='lesson_request_approval.php?lesson_id={$lesson_id}&request_user_id={$request_user_id}&request_lesson_id={$request_lesson_id}'>$request_user_name</a>";
                        print '<img class="image" src="./picture/'.$request_user_picture.'">';
                        print '<p class="text_no_matching">リクエスト待ち</p>';
                        print '</div>';
                    }  
                    }
                    
                    }
                ?>
            </main>
            <main class="main">
                <?php 
    //5.表示文字列を作成→変数に追記で代入
                    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $code=$result['id'];
                        $name=$result['name'];
                        $email=$result['email'];
                        $age=$result['age'];
                        //性別
                        $sex=$result['sex'];
                        $sex_jp=sex($sex);
                        //得意な言語
                        $main=$result['main_language'];
                        $main_jp=main($main);
                        //学びたい言語
                        $sub=$result['sub_language'];
                        $sub_jp=sub($sub);
                        //画像の表示
                        $picture=$result['picture'];
                        print '<h2>プロフィール</h2>';
                        print '<div class="article-box">';
                        print '<img class="image" src="./picture/'.$picture.'">';
                        print '<p class="desc">'.'名前：'.$name.'</p>';
                        print '<p class="desc">'.'メールアドレス：'.$email.'</p>';
                        print '<p class="desc">'.'年齢：'.$age.'</p>';
                        print '<p class="desc">'.'性別：'.$sex_jp.'</p>';
                        print '<p class="desc">'.'得意な言語：'.$main_jp.'</p>';
                        print '<p class="desc">'.'学びたい言語：'.$sub_jp.'</p>';
                        print '<br />';
                        print "<a href='update.php'>更新する</a>";
                        print '</div>';
                    }
                */?>
            </main>
        </div>
        <footer class="footer">
            <ul class="horizontal-list">
                <li class="horizontal-item"><a href="#">ABOUT ME</a></li>
                <li class="horizontal-item"><a href="#">SITE MAP</a></li>
                <li class="horizontal-item"><a href="#">CONTACT</a></li>
                <li class="horizontal-item"><a href="logout.php">ログアウト</a></li>
            </ul>
            <p class="copyright">Copyright © 2015 SAMPLE SITE</p>
        </footer>
    </body>

    </html>