<?php

class UserAPI {

	private $_db;

	public function __construct() {
		$this->_db = new DatabaseAPI();
	}

	public function userLoad($type = false){
		if(isset($_SESSION['user'])){
			return $this->userLogin($_SESSION['user']->openid);
		} else {
			if ($type == true) {
				return false;
			}
			$WechatAPI = new WechatAPI();
			$WechatAPI->wechatAuthorize();
		}
		
	}

	public function userLogin($openid){
		$result = $this->_db->findUserByOpenid($openid);
		$user = $result ? $result : $this->userRegister($openid);
		$_SESSION['user']->openid = $openid;
		return $user;
	}

	public function userRegister($openid){
		return $this->_db->insertUser($openid);
	}
}