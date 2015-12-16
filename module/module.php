<?php

function _wechat_getdata() {
	$post = $GLOBALS['HTTP_RAW_POST_DATA'];
	exit;
}

function _wechat_callback() {
	$openid = $_GET['openid'];
	$user = new UserAPI();
	$user->userLogin($openid);
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
		print '<script>var CANSHAKE="'.$user->status.'";</script>';
		$cardList = $wechatAPI->cardList();
		print '<script>var cardListJSON = '.json_encode($cardList).'</script>';
		exit;
	}

}

function _api_status() {
	$UserAPI = new UserAPI();
	$user = $UserAPI->userLoad(true);
	if ($user) {
		print json_encode(array("code" => 1, "msg" => $user->status));
		exit;
	}
	print json_encode(array("code" => 0, "msg" => "请先登录"));
	exit;
}

function _api_lotterylist() {
	$RedisAPI = new RedisAPI();
	$list = $RedisAPI->getLotteryList();
	if (!$list) {
		print json_encode(array("code" => 2, "msg" => "没有人中奖"));
		exit;
	}	
	print json_encode(array("code"=>1,"msg"=>$list));
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
			print json_encode(array("code"=>4,"msg"=>"没有抽奖机会"));
		    exit;
		}
		$_SESSION['user']->status = 0;
		if ($user->lottery > 0) {
			//只能中卡券
			print json_encode(array("code"=>2,"msg"=>"卡券"));
		    exit;
		}
		$rand = rand(1, 10000);
		if ($rand <= 5000) {
			//包包
			$DatabaseAPI->setPrizeRecord($user->uid, 1, $user->basename);
			print json_encode(array("code"=>1,"msg"=>"礼品"));
		    exit;
		}
		//未中奖
		$DatabaseAPI->setPrizeRecord($user->uid, 2, $user->basename);
		print json_encode(array("code"=>3,"msg"=>"未中奖"));
	    exit;
	}
	print json_encode(array("code"=>0,"msg"=>"请先登录"));
	exit;
}

function _api_share() {
	$UserAPI = new UserAPI();
	$user = $UserAPI->userLoad(true);
	if ($user) {
		$_SESSION['user']->status = 1;
		print json_encode(array("code"=>1,"msg"=>"分享成功"));
		exit;
	}
	print json_encode(array("code"=>0,"msg"=>"请先登录"));
	exit;
}

?>