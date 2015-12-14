<?php

class UserAPI {

	private $_db;

	public function __construct() {
		$this->_db = new DatabaseAPI();
	}

	public function userLoad(){

		if(isset($_SESSION['openid'])){
			return $this->userLogin($_SESSION['openid']);
		} else {
			$WechatAPI = new WechatAPI();
			$WechatAPI->wechatAuthorize($_SERVER['REQUEST_URI']);
		}
		
	}

	public function userLogin($openid){
		$result = $this->_db->findUserByOpenid($openid);
		$user = $result ? $result : $this->userRegister($openid);
		$_SESSION['openid'] = $openid;
		return $user;
	}

	public function userRegister($openid){
		return $this->_db->insertUser($openid);
	}
}