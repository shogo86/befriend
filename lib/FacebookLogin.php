<?php

namespace MyApp;

class FacebookLogin {
    private $_fb;

    public function __construct() {
        $this->_fb = new \Facebook\Facebook([
            'app_id' => APP_ID,
            'app_secret' => APP_SECRET,
            'default_graph_version' => APP_VERSION,
        ]);
    }

  public function isLoggedIn() {
      //セッションがある場合はログインとみなす
      return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

  //ログインボタンを押したときの処理    
  public function login() {
      //もしログインしていたら登録画面に飛ばす
      if ($this->isLoggedIn()) {
          header('Location: http://' . $_SERVER['HTTP_HOST']. '/graduation/user_entry.php');
      }

      //facebookログインに飛ばす
      $helper = $this->_fb->getRedirectLoginHelper();

      // get access token
      try {
        $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exception\FacebookResponseException $e) {
        echo 'Response Error: ' . $e->getMessage();
        exit;
        } catch (\Facebook\Exception\FacebookSDKException $e) {
        echo 'SDK Error: ' . $e->getMessage();
        exit;
        }

      //アクセストークンが取得できている場合の処理
      if (isset($accessToken)) {
        // save user
        // var_dump($accessToken);
        
        //accessTokenを有効期間の長いものに入れ替える
        if (!$accessToken->isLongLived()) {
            try {
                //accessTokenを入れ替える
                $accessToken = $this->_fb->getOAuth2Client()->getLongLivedAccessToken($accessToken);
                //例外の場合にメッセージ表示
                } catch (\Facebook\Exception\FacebookSDKException $e) {
                echo 'LongLived Access Token Error: ' . $e->getMessage();
                exit;
            }
        }
          $this->_save($accessToken);
          header('Location: http://' . $_SERVER['HTTP_HOST']. '/graduation/user_entry.php');
          //キャンセルが押された場合にホーム場面に飛ばす
        } elseif ($helper->getError()) {
          goHome();
        } else {
          //permissionの設定
          $permissions = ['email', 'user_posts '];
          $loginUrl = $helper->getLoginUrl(CALLBACK_URL, $permissions);
          //ログイン画面に飛ばす
          header('Location: ' . $loginUrl);
        }
        exit;
  }

    private function _save($accessToken) {
        // get user info
        $fb = new Facebook($accessToken);
        $userNode = $fb->getUserNode();
        // var_dump($userNode); exit;

        // save user
        $user = new User();
        $me = $user->save($accessToken, $userNode);
        // var_dump($me);
        // exit;

        // login
        //セッションハイジャック対策
        session_regenerate_id(true);
        $_SESSION['me'] = $me;
    }
}

?>