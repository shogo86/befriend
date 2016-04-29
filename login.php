<?php

//関数の読み込み
require_once(__DIR__ . '/config.php');

//ログイン周りの処理をまとめる
$fbLogin = new Myapp\FacebookLogin();

//インスタンスのログインメソッドを呼び出す
try{
    $fbLogin->login();
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}


?>