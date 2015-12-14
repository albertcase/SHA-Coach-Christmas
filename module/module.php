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
	$user->userLogin($userinfo['data']['openid']);
	header("Location:/");
	exit;
}

function _access_listener() {
	$UserAPI = new UserAPI();
	$user = $UserAPI->userLoad();
	if ($user) {
		$wechatAPI = new WechatAPI();
		$re = $wechatAPI->isUserSubscribed($user->openid);
		if (!$re) {
			print file_get_contents(TEMPLATE_ROOT . 'qrcode.html');
			exit;
		}
		print file_get_contents(TEMPLATE_ROOT . 'home.html');
		exit;
	}

}

function _api_status() {
	$UserAPI = new UserAPI();
	$user = $UserAPI->userLoad(true);
	if ($user) {
		print json_encode(array("code"=>1,"msg"=>$user->status));
		exit;
	}
	print json_encode(array("code"=>0,"msg"=>"请先登录"));
	exit;
}

function _api_lotterylist() {
	$DatabaseAPI = new DatabaseAPI();
	$list = $DatabaseAPI->loadLotteryList();
	if (!$list) {
		print json_encode(array("code"=>2,"msg"=>"没有人中奖"));
		exit;
	}
	$newList = array();
	for ($i=0 ; $i < count($list); $i++) {
		$name = json_decode($list[$i], true);
        $newList[$i]['nickname'] = emoji_unified_to_html($name['name']);
	}
	
	print json_encode(array("code"=>1,"msg"=>$newList));
	exit;
}

function _api_saveinfo() {
	$tag = false;
	$name = isset($_POST['name']) ? $_POST['name'] : $tag = true;
	$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : $tag = true;
	if ($tag) {
		print json_encode(array("code"=>2,"msg"=>"请填写必填项"));
		exit;
	}
	$UserAPI = new UserAPI();
	$user = $UserAPI->userLoad(true);
	if ($user) {
		$DatabaseAPI = new DatabaseAPI();
		$re = $DatabaseAPI->finishInfo($name, $mobile, $user->uid);
		if ($re) {
			print json_encode(array("code"=>1,"msg"=>"提交成功"));
			exit;
		}
	}
	print json_encode(array("code"=>0,"msg"=>"请先登录"));
	exit;
}

function _api_lottery() {
	$UserAPI = new UserAPI();
	$user = $UserAPI->userLoad(true);
	if ($user) {
		$DatabaseAPI = new DatabaseAPI();
		if ($user->status == 0) {

		}
		$rand = rand(1,3);
		if($rand == 1) {
			//1000元
			print json_encode(array("code"=>1,"msg"=>"礼品"));
		    exit;
		} else if ($rand == 2) {
			//卡券
			print json_encode(array("code"=>2,"msg"=>"卡券"));
		    exit;
		} else {
			//未中奖
			print json_encode(array("code"=>3,"msg"=>"未中奖"));
		    exit;
		}
	}
	print json_encode(array("code"=>0,"msg"=>"请先登录"));
	exit;
}

?>