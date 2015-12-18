<?php

function _wechat_getdata() {
	$data = $GLOBALS['HTTP_RAW_POST_DATA'];
	$data = json_decode($data, true);
	$DatabaseAPI = new DatabaseAPI();
	$DatabaseAPI->regUser($data['data']['openid'], $data['data']['nickname'], $data['data']['headimgurl']);
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
		//$re = 1;
		if (!$re) {
			print file_get_contents(TEMPLATE_ROOT . 'qrcode.html');
			exit;
		}
		print file_get_contents(TEMPLATE_ROOT . 'home.html');
		print '<script>var CANSHAKE="'.$user->status.'";</script>';
		$cardList = $wechatAPI->cardList();
		print '<script>var cardListJSON = '.json_encode($cardList).'</script>';
		$RedisAPI = new RedisAPI();
		$list = $RedisAPI->getLotteryList();
		if (!$list) {
			print '<script>var lotteryList = '.json_encode(array("code" => 2, "msg" => "目前没有人中奖")).'</script>';
			exit;
		}	
		print '<script>var lotteryList = '.json_encode(array("code" => 1, "msg" => $list)).'</script>';
		exit;
	}

}

function _api_status() {
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
	    // ajax 请求的处理方式 
		$UserAPI = new UserAPI();
		$user = $UserAPI->userLoad(true);
		if ($user) {
			print json_encode(array("code" => 1, "msg" => $user->status));
			exit;
		}
		print json_encode(array("code" => 0, "msg" => "请先登录"));
		exit;
	}
}

function _api_lotterylist() {
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
	    // ajax 请求的处理方式 
		$RedisAPI = new RedisAPI();
		$list = $RedisAPI->getLotteryList();
		if (!$list) {
			print json_encode(array("code" => 2, "msg" => "没有人中奖"));
			exit;
		}	
		print json_encode(array("code"=>1,"msg"=>$list));
		exit;
	}
}

function _api_saveinfo() {
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
	    // ajax 请求的处理方式 
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
}

function _api_lottery() {
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
	    // ajax 请求的处理方式 
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
			$rand = rand(1, 100000);
			if ($rand <= 10) {
				//包包
				$totalcount = $DatabaseAPI->totalcount();
				if ($totalcount>=20) {
					$DatabaseAPI->setPrizeRecord($user->uid, 2);
					print json_encode(array("code"=>3,"msg"=>"未中奖"));
				    exit;
				}
				$DatabaseAPI->setPrizeRecord($user->uid, 1);
				print json_encode(array("code"=>1,"msg"=>"礼品"));
			    exit;
			}
			//未中奖
			$DatabaseAPI->setPrizeRecord($user->uid, 2);
			print json_encode(array("code"=>3,"msg"=>"未中奖"));
		    exit;
		}
		print json_encode(array("code"=>0,"msg"=>"请先登录"));
		exit;
	}
}

function _api_share() {
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
	    // ajax 请求的处理方式 
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
}

function _api_refreshlist() {
	$RedisAPI = new RedisAPI();
	$list = $RedisAPI->refreshList();
	print json_encode(array("code"=>1,"msg"=>$list));
}
?>