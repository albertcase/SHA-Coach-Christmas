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
		print '<script>var CANSHAKE="'.$user->status.'";<script>';
		$access_token = '08ecb2077e158fd621a1f175e22442e8';
		$api_url = 'http://api.curio.im/v2/wx/card/js/add/json?access_token='. $access_token;
		// 参数数组
		$data[] = array(
		        'card_id' => 'pKCDxjlrh6tQ8sEDiZl9eAmKcXqA',
		        'code' => '',
		        'openid' => ''
		);
		 
		$ch = curl_init ();
		// print_r($ch);
		curl_setopt ( $ch, CURLOPT_URL, $api_url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		$return = json_decode($return,true);
		$cardList = $return['data']['cardList'];
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