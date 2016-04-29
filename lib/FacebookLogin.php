<?php

namespace Myapp;

//classの作成
class FacebookLogin {
        //プライベートプロパティ
        private $_fb;
        
        //インスタンスの作成
        public function __construct() {
            $this->_fb = new \Facebook\Facebook([
                'app_id' => APP_ID,
                'app_secret' => APP_SECRET,
                'default_graph_version' => APP_VERSION,
            ]);
        }
        
        public function login(){
            //facebookログインのページに飛ばす
            $helper = $this->_fb->getRedirectLoginHelper();
            
            //facebookログイン画面のURLの生成を行う
            //CALLBACK_URLはconfigで管理する
            $loginUrl = $helper->getLoginUrl(CALLBACK_URL);
            header('location: ' . $loginUrl);
            exit;
        }
        
        
}

?>