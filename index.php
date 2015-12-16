<?php
ini_set("display_errors", 1);
Session_Start();
require_once dirname(__FILE__) . "/conf/config.php";
require_once dirname(__FILE__) . "/module/module.php";
require_once dirname(__FILE__) . "/module/emoji.php";


$routers = array();
$routers['/api/getdata'] = '_wechat_getdata';
$routers['/api/callback'] = '_wechat_callback';
$routers['/api/status'] = '_api_status';
$routers['/api/lotterylist'] = '_api_lotterylist';
$routers['/api/saveinfo'] = '_api_saveinfo';
$routers['/api/lottery'] = '_api_lottery';
$routers['/api/share'] = '_api_share';

$listener = array();
$listener[] = '/';
$listener[] = '/index.php';

$current_router = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);

if(in_array($current_router, $listener))
 	call_user_func_array('_access_listener', array());

if(isset($routers[$current_router]))
	call_user_func_array($routers[$current_router], array());
?>
