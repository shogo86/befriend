<?php

//エラー表示をブラウザに出力する
ini_set('display_errors', 1);

//オートロードを読み込む
require_once(__DIR__ . '/vendor/autoload.php');

//facebook連携の設定
define('APP_ID', '550479261789533');
define('APP_SECRET', '2240419e4caf81982f0842f3e9c6899f');
define('APP_VERSION', 'v2.6');

//DBの設定
define('DSN', 'mysql:host=localhost;dbname=befriend');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'shogo0141');

//ログイン時に飛ばす
define('CALLBACK_URL', 'http://' .$_SERVER['HTTP_HOST']. '/login.php');
//define('CALLBACK_URL', 'http://' .$_SERVER['HTTP_HOST']. '/login.php');

//セッションを行う
session_start();

//よく使う関数の参照
require_once(__DIR__ . '/functions.php');

//DB接続をする
$dsn='mysql:dbname=befriend;host=localhost;';
$user='dbuser';
$password='shogo0141';
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');


?>