<?php

//エラー表示をブラウザに出力する
ini_set('display_errors', 1);

//オートロードを読み込む
require_once(__DIR__ . '/vendor/autoload.php');

//facebook連携の設定
define('APP_ID', '1703235536621063');
define('APP_SECRET', '480a3fcb188b65ae50162d84f4190ce0');
define('APP_VERSION', 'v2.6');

//DBの設定
define('DSN', 'befriend');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'shogo0141');

//ログイン時に飛ばす
define('CALLBACK_URL', 'http://' .$_SERVER['HTTP_HOST']. '/login.php');

//セッションを行う
session_start();

//よく使う関数の参照
require_once(__DIR__ . '/functions.php');


?>