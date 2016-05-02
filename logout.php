<?php

require_once(__DIR__ . '/config.php');

//POSTできたら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    //CSRF対策
    try {
        MyApp\Token::validate('token');
        } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
    

    //セッションの中身を空にする
    $_SESSION = [];

    //Cookieがセットされている場合はCookieを削除する
    if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
    }
    
    //セッションに関連づけられたデータを削除する
    session_destroy();
}

//HOME画面へ飛ばす
goHome();

?>