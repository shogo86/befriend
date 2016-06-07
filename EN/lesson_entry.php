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
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <title>レッスン登録</title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:700,400">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/lesson_list.css">



    </head>

    <body>
        <header id="header">
            <div class="global-nav">
                <ul>
                    <li class="nav-item active"><a href="lesson_list.php">LESSON一覧</a></li>
                    <li class="nav-item"><a href="#">ユーザー検索</a></li>
                    <li class="nav-item"><a href="#">イベント検索</a></li>
                    <!--<li class="nav-item"><a href="mypage.php"><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></a></li>-->
                </ul>
            </div>
            <p class="image"><a href="mypage.php"><img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic"></a></p>
            <p class="name"><a href="mypage.php"><?= h($me->fb_name); ?></a></p>
            <p class="lesson_entry"><a href="lesson_entry.php">レッスン登録</a></p>
            <p class="befriend"><a href="lesson_list.php">Befriend</a></p>
        </header>

        <section class="contact" id="contact">
            <h2 class="heading">レッスン登録</h2>
            <form class="contact-form" method="post" action="lesson_entry_done.php">
                <div class="day_all">
                <p class="day_text">日付</p>
                <input type="date" name="day" min="2016-05-01" required class="day">
                </div>
                <div class="time_all">
                <p class="time_text">開始時間</p>
                <div class="time">
                <select name="hour" required>
                    <option value="">時</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    </select>
                <select name="minute" required>
                    <option value="">分</option>
                    <option value="1">00</option>
                    <option value="2">15</option>
                    <option value="3">30</option>
                    <option value="4">45</option>
                </select>
                    </div>
                <div class="lesson">
                <p class="lesson_time">レッスン時間</p>    
                <select name="time" required>
                    <option value="">レッスン時間</option>
                    <option value="1">30分</option>
                    <option value="2">60分</option>
                </select>
                </div>
                </div>
                <!--</div>-->
                <div class="state_all">
                <p class="place_text">都道府県</p>
                <select name="state" required class="state">
                    <option value="">都道府県を選択してください</option>
                    <option value="1">北海道</option>
                    <option value="2">青森県</option>
                    <option value="3">岩手県</option>
                    <option value="4">宮城県</option>
                    <option value="5">秋田県</option>
                    <option value="6">山形県</option>
                    <option value="7">福島県</option>
                    <option value="8">茨城県</option>
                    <option value="9">栃木県</option>
                    <option value="10">群馬県</option>
                    <option value="11">埼玉県</option>
                    <option value="12">千葉県</option>
                    <option value="13">東京都</option>
                    <option value="14">神奈川県</option>
                    <option value="15">新潟県</option>
                    <option value="16">富山県</option>
                    <option value="17">石川県</option>
                    <option value="18">福井県</option>
                    <option value="19">山梨県</option>
                    <option value="20">長野県</option>
                    <option value="21">岐阜県</option>
                    <option value="22">静岡県</option>
                    <option value="23">愛知県</option>
                    <option value="24">三重県</option>
                    <option value="25">滋賀県</option>
                    <option value="26">京都府</option>
                    <option value="27">大阪府</option>
                    <option value="28">兵庫県</option>
                    <option value="29">奈良県</option>
                    <option value="30">和歌山県</option>
                    <option value="31">鳥取県</option>
                    <option value="32">島根県</option>
                    <option value="33">岡山県</option>
                    <option value="34">広島県</option>
                    <option value="35">山口県</option>
                    <option value="36">徳島県</option>
                    <option value="37">香川県</option>
                    <option value="38">愛媛県</option>
                    <option value="39">高知県</option>
                    <option value="40">福岡県</option>
                    <option value="41">佐賀県</option>
                    <option value="42">長崎県</option>
                    <option value="43">熊本県</option>
                    <option value="44">大分県</option>
                    <option value="45">宮崎県</option>
                    <option value="46">鹿児島県</option>
                    <option value="47">沖縄県</option>
                </select>
                    </div>
                <div class="street_all">
                <p class="street_text">詳細住所</p>
                <textarea name="street" rows="2" cols="80" placeholder="詳細の記入をしてください" class="street" required ></textarea>
                </div>
                <div class="detail_all">
                <p class="detail_text">その他</p>
                <textarea name="detail" rows="5" cols="80" placeholder="詳細の記入をしてください" class="detail"></textarea>
                </div>
                <input type="submit" value="上記の内容で登録する" class="submit_button">
            </form>
        </section>
        <footer class="footer">
            <ul class="horizontal-list">
                <li class="horizontal-item"><a href="#">ABOUT US</a></li>
                <li class="horizontal-item"><a href="#">利用規約</a></li>
                <li class="horizontal-item"><a href="#">CONTACT</a></li>
                <li class="horizontal-item"><a href="logout.php">ログアウト</a></li>
            </ul>
            <p class="copyright">Copyright © 2016 Befriend</p>
        </footer>
        <script src="lib/placeholders.min.js"></script>
    </body>

    </html>
