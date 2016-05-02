<?php

namespace MyApp;

class Facebook {
    private $_fb;

    //facebook連携を行う
    public function __construct($accessToken) {
        $this->_fb = new \Facebook\Facebook([
        'app_id' => APP_ID,
        'app_secret' => APP_SECRET,
        'default_graph_version' => APP_VERSION,
        ]);
        $this->_fb->setDefaultAccessToken($accessToken);
    }

    //ユーザー情報を取得する
    public function getUserNode() {
        $process = function() {
            $res = $this->_fb->get('/me?fields=id,name,email,link');
            $userNode = $res->getGraphUser();
            return $userNode;
        };
        return $this->_request($process);
    }

    //例外処理への対策
    private function _request($process) {
        try {
            $res = $process();
        } catch (\Facebook\Exception\FacebookResponseException $e) {
            echo 'Response Error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exception\FacebookSDKException $e) {
            echo 'SDK Error: ' . $e->getMessage();
            exit;
        }
        return $res;
    }

    //投稿情報を取得する    
    public function getPosts() {
        $process = function() {
            $res = $this->_fb->get('/me/posts?limit=3');
            $body = $res->getDecodedBody();
        if (empty($body['data'])) {
            return [];
        } else {
            return $body['data'];
        }
        };
        return $this->_request($process);
    }

}

?>