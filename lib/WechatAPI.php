<?php

class WechatAPI {

  private $_token;
  private $_appid;
  private $_appsecret;

  public function __construct() {
    // $this->_token = TOKEN;
    // $this->_appid = APPID;
    // $this->_appsecret = APPSECRET;
  }



  public function wechatAuthorize() {
    $url = CURIO_AUTH_URL;
    header("Location:" . $url);
    exit;
  }

  public function getUserInfo($openid) {
  	$info = file_get_contents("http://api.curio.im/v2/wx/users/" . $openid . "?access_token=" . CURIO_TOKEN);
    $rs = json_decode($info, true);
    return $rs;
  }

  public function isUserSubscribed($openid) {
    $info = $this->getUserInfo($openid);
    if(isset($info['data']['subscribe']) && $info['data']['subscribe'] == 1)
      return TRUE;
    else
      return FALSE;
  }

}

?>