<?php

namespace MyApp;

//CSRF対策のためのToken
class Token {

    //Tokenを作る
    static public function create() {
        //トークンがセッションにセットされていない場合、
        if (!isset($_SESSION['token'])) {
            //推測されづらい文字列に置き変える
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
    }

    //Tokenを検証する
    //下記の条件をクリアしない場合に例外を投げる
    static public function validate($tokenKey) {
        if (
            //セッションのTokenがセットされていない場合
            !isset($_SESSION['token']) ||
            //POSTのToken keyがセットされていない場合
            !isset($_POST[$tokenKey]) ||
            //セッションのTokenとPOSTのTokenが一致していない場合
            $_SESSION['token'] !== $_POST[$tokenKey]
        ) {
            throw new \Exception('invalid token!');
            
        }
    }

}

?>