<?php

function _home() {
	print file_get_contents(TEMPLATE_ROOT . 'index.html');
}

function _api() {

	$user = new UserAPI();

	if(!isset($_POST['level'])){
		print json_encode(array('status' => '002')); //level is empty
		exit;
	}

	$user = $user->userLoad();

	$DatabaseAPI = new DatabaseAPI();
	$re = $DatabaseAPI->setPrizeRecord($user->uid, $_POST['level']);
	$status = $re ? 1 : 0;
	print json_encode(array('status' => $status));
	exit;
}

function _wechat_getdata() {
	$post = $GLOBALS['HTTP_RAW_POST_DATA'];
	exit;
}

function _wechat_callback() {
	$openid = $_GET['openid'];
	$wechatAPI = new WechatAPI();
	$userinfo = $wechatAPI->getUserInfo($openid);
	$user = new UserAPI();
	$user->userLogin($userinfo->openid);
	header("Location:/");
	exit;
}

function _access_listener() {
	$UserAPI = new UserAPI();
	$user = $UserAPI->userLoad();
	if($user) {
		$wechatAPI = new WechatAPI();
		$re = $wechatAPI->isUserSubscribed($user->openid);
		if(!$re) {
			print file_get_contents(TEMPLATE_ROOT . 'home.html');
			print '<script>window.unsubscribed = true;</script>';
			exit;
		}
		print file_get_contents(TEMPLATE_ROOT . 'qrcode.html');
		exit;
	}

}

?>