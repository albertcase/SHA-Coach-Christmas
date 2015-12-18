<?php
$tag = $_GET['tag'];
require_once dirname(__FILE__) . "/conf/config.php";
$user = new stdClass();
$user->uid = 1;
$user->openid = 'oKCDxjvvyfIqg0lKXNJrc0szWzSg';
$user->lottery = 0;
$user->status = 1;
if ($tag ==1) {
    $wechatAPI = new WechatAPI();
    $re = $wechatAPI->isUserSubscribed($user->openid);
} else {
    $re = 1;
}
if (!$re) {
    print file_get_contents(TEMPLATE_ROOT . 'qrcode.html');
    exit;
}
print file_get_contents(TEMPLATE_ROOT . 'home.html');
print '<script>var CANSHAKE="'.$user->status.'";</script>';
if ($tag == 1) {
    $cardList = $wechatAPI->cardList();
    print '<script>var cardListJSON = '.json_encode($cardList).'</script>';
} else {
    print '<script>var cardListJSON = {}</script>';
}

$RedisAPI = new RedisAPI();
$list = $RedisAPI->getLotteryList();
if (!$list) {
    print '<script>var lotteryList = '.json_encode(array("code" => 2, "msg" => "没有人中奖")).'</script>';
    exit;
}   
print '<script>var lotteryList = '.json_encode(array("code" => 1, "msg" => $list)).'</script>';
exit;
?>
