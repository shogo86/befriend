<?php
//セッション変数を空にする
$_SESSION=array();
if(isset($_COOKIE[session_name()])==true)
{
    //PC側のセッションIDをクッキーから削除する
    setcookie(session_name(),'',time()-42000,'/');
}
//セッションを破棄する
@session_destroy();
?>


    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>ログアウト</title>
    </head>

    <body>
        ログアウトしました。
        <br />
        <br />
        <a href="toppage.php">ログイン画面へ</a>
    </body>

    </html>