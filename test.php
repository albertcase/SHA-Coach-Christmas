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
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>遇见COACH圣诞好礼</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" >
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" type="text/css" href="http://coachxmas.samesamechina.com/dist/style.css?v=1"/>
    <script type="text/javascript">
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?c792d889f71f75405d19198872cba4ca";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <script type="text/javascript" src="http://wechatjs.curio.im/api/v1/js/10b39d84-e3e5-4f50-873f-76ec05ed6aaf/wechat.js"></script>
    <script type="text/javascript" src="http://coachxmas.samesamechina.com/dist/js/jrem.js?v=1"></script>
    <script type="text/javascript" src="http://coachxmas.samesamechina.com/dist/js/all.js?v=1"></script>
</head>
<body>
<div class="preloading">
    <div class="inner">
        <div class="l-logo">
            <img src="http://coachxmas.samesamechina.com/img/loading-logo.png" alt=""/>
        </div>
        <div class="icon-loading">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <p class="des-loading">
            目前涌入的小伙伴过多<br>
            页面正在跳转中，请耐心等待。
        </p>
    </div>
</div>
<div class="wrapper">
    <div class="wrap">
        <!-- Homepage 我要摇奖 -->
        <section class="pin pin-1">
            <div class="p1-1">
                <img src="http://coachxmas.samesamechina.com/img/v2/p1-1.png" alt=""/>
            </div>
            <p class="p1-des">
                感谢您<br>
                在这一年的陪伴和分享<br><br>
                今年圣诞<br>
                所有的惊喜<br>
                让COACH来为你准备<br><br>
                拿起手机摇一摇<br>
                遇见最贴心的圣诞礼物
            </p>
            <div class="marquee-wrap">
                <div class="p1-2" id="marquee">
                    <ul class="list">
                    </ul>
                </div>
            </div>
            <div class="p1-3 buttons">
                我要摇奖
            </div>
            <div class="p1-5">
                活动细则
            </div>
        </section>

        <!-- 摇一摇-->
        <section class="pin pin-2">
            <div class="p2-shake">
                <img src="http://coachxmas.samesamechina.com/img/v2/icon-sp.png" alt=""/>
            </div>
            <div class="p2-t1">
                摇一摇
            </div>
            <div class="p2-1 animate-gif">
                <img src="http://coachxmas.samesamechina.com/img/v2/dog-1.jpg" alt=""/>
            </div>
            <div class="p2-2">
                遇见 . 圣诞好礼
            </div>
        </section>

        <!-- 摇一摇成功页面 -->
        <section class="pin pin-3">
            <!-- get prize-->
            <div class="prize prize-1">
                <div class="pz-1">
                    <span class="p3-t1">恭喜你摇到了</span>
                    价值千元的COACH福袋
                </div>
                <div class="p3-1 animate-gif">
                    <img src="http://coachxmas.samesamechina.com/img/v2/dog-2.png" alt=""/>
                </div>
            </div>
            <!-- 1000元prize-->
            <div class="prize prize-2">
                <div class="pz-1">
                    <span class="p3-t1">恭喜你摇到了</span>
                    COACH圣诞钟情礼券
                </div>
                <div class="p3-1 animate-gif">
                    <img src="http://coachxmas.samesamechina.com/img/v2/dog-2-2.png" alt=""/>
                </div>
            </div>
            <div class="p3-5 buttons">
                留下你的获奖信息
            </div>
            <div class="gocoupon buttons coupon-1">
                领取圣诞礼券
            </div>
        </section>

        <!-- 摇一摇失败页面 -->
        <section class="pin pin-4">
            <div class="prize no-prize">
                <span class="p3-t1">很遗憾</span>
                你没有摇到礼物
            </div>
            <div class="p3-1 animate-gif">
                <img src="http://coachxmas.samesamechina.com/img/v2/dog-3.png" alt=""/>
            </div>
            <!-- 1000元prize-->
            <div class="p4-5 buttons">
                再摇一次
            </div>
        </section>

        <!-- 填写个人信息-->
        <section class="pin pin-5">
            <p class="p4-txt">
                圣诞老人准备出发了
                <strong>请完善以下信息</strong>
            </p>
            <form action="post" id="form-contact">
                <div class="input-box input-box-name">
                    <input type="text" name="name" class="input-name" placeholder="姓名/NAME"/>
                </div>
                <div class="input-box input-box-phone">
                    <input type="tel" name="phone" class="input-phone" maxlength="11" placeholder="手机/MOBILE PHONE"/>
                </div>
                <div class="buttons btn-submit">
                    提交
                </div>
            </form>
        </section>

        <!-- 礼物页面-->
        <section class="pin pin-6">
            <div class="p6-2">
                提交成功
            </div>
            <div class="p6-1 animate-gif">
                <img src="http://coachxmas.samesamechina.com/img/v2/dog-4.png" alt=""/>
            </div>
            <div class="buttons gocoupon coupon-2">
                领取圣诞礼券
            </div>
        </section>

        <!-- 活动细则-->
        <section class="pin pin-7">
           <h3 class="title">活动细则</h3>
            <div class="content-wrap">
                <p class="content content-1">
                    参与本活动无需以购买蔻驰产品或服务为前提。购买我们的产品或服务并不会增加你在本次活动中的获胜机会。
                </p>
                <p class="content content-2">
                    1. 参与资格: 任何年满18岁的中国公民均有资格参与蔻驰微信“摇一摇，遇见COACH圣诞好礼”活动（以下简称本活动）。蔻驰在中国的雇员、经理和各级代表及其直系亲属（父母，配偶，子女，兄弟姐妹）及家庭成员不得参与本次活动。本次活动将严格遵守中华人民共和国的相关法律及法规。参与本活动表示你同意无条件完全遵守本活动细则以及活动主办方的相关决定。奖品的获取是在参与者完成了所有规定任务之后按完成时间优先排序选取的。
                </p>
                <p class="content content-2">
                    2. 活动主办方: 蔻驰贸易（上海）有限公司
                    南京西路1717号会德丰广场20楼，200042.
                </p>
                <p class="content content-3">
                    3. 活动时间: 本活动将于2015年12月18日北京时间上午10点开始，截止时间为2015年12月27日，活动主办方的电脑时间为本次活动的官方时间标准。
                </p>
                <p class="content content-3">
                    4. 怎样参与本次活动:<br>
                    在活动期间，所有添加蔻驰官方微信账号的用户，根据账号内指引进行活动提交，主办方会随机抽取50名获得奖品，并通过蔻驰官方微信账号通知用户领取奖品。如果你是活动的首个参与者或者是在其他时间参与活动都有机会获奖。所有获奖者在领取奖品前都必须经过验证（在微信绑定用户的手机号码及提交完整有效的收货地址）。活动主办方有义务在活动期间保证活动功能可被正常使用。
                </p>
                <p class="content content-3">
                    5. 所有获奖的行为必须经过活动主办方的认证方始有效。只有当活动参与者的身份被认定核实并且获得官方通知之后，才能获取奖品。主办方不会接受截图或者其他的证据来验证获奖资格。在活动期间，如果在系统出现问题时产生的结果是不会被视作有效的。
                </p>
                <p class="content content-3">
                    6. 获奖者的认证：所有的活动参与者都必须满足活动细则中的所有条款。获取奖品的先决条件是必须完成所有相关的任务。活动主办方在法律允许范围内负责制定、解释、修改并及时公布本次活动的规则，并最终确定获奖者。
                </p>
                <p class="content content-3">
                    7. 奖品: 蔻驰提供的COACH品牌礼品五十份，以福袋形式发出，价值899 &nbsp;-&nbsp; 4999元不等，奖品随机赠送。
                </p>
                <p class="content content-3">
                    8.活动信息公告：在符合法律相关规定的情况下，获奖者必须同意活动主办方在媒体上披露获奖者的姓名，照片，语音，意见，身份信息和居住城市，主办方并不需要为此再支付额外费用或另行通知。活动主办方有权依据相关法律法规或业务需要，中止或取消此次活动或者修改活动方案，经相关途径公告后生效。
                </p>
                <p class="content content-3">
                    9.一般性条款：如果发现欺诈，或者技术事故，或者由超出活动主办方能力控制的影响活动公正性的情况发生，活动主办方保留单方面取消或者变更本活动的相关权利。如果发生类似情况，活动主办方保留随机发送奖品給予事故发生前活动参赛者的权利。活动主办方同时保留在参赛者违反公平性原则或者利用不当行为获利的情况下单方面取消参赛者资格的权利。活动主办方保留采取法律手段追诉对于蓄意破坏和攻击活动网站的人的权利并可能要求相关赔偿。
                </p>
                <p class="content content-3">
                    10. 豁免条款: 参与本次活动的参赛者不得采用任何直接或者间接的方式沟通或者伤害任何蔻驰贸易（上海）有限公司及其合作伙伴及和本次活动有关的任何相关公司的雇员。
                </p>
                <p class="content content-3">
                    11. 相关责任: 活动主办方不对以下情况负责：
                    1.由媒体提供的关于本次活动的任何不准确或者不精确的信息
                    2.任何形式的技术故障，包括软硬件的损坏或者网络问题
                    3.对于本次活动的人为的恶意破坏
                    4.技术或人为的监管问题
                    5.因为参加本次活动直接或间接而产生的人身伤害。
                    6.如果因为技术或者收到恶意攻击等原因导致实际获奖者总人数超过事先公布的人数，活动主办方保留从中按照事先公布的获奖总数从中随机抽取的权利。
                </p>
                <p  class="content">
                    12. 获奖者名单的公布：获奖者名单将会在收集到所有的获奖者信息之后在蔻驰微信账号公布。
                </p>
                <p class="content">
                    13.获奖者奖品的发放：获奖者奖品将会发送至得奖用户提交的有效地址，通过指定快递公司的方式进行发放。如果得奖用户的地址信息不完整或者错误导致的投递失败，经沟通无法获得准确个人信息及地址的，蔻驰贸易(上海)有限公司有权取消该名中奖用户的获奖资格。
                </p>
            </div>
            <div class="buttons p7-btn">
                知道了
            </div>
        </section>
    </div>
    <div class="share">
        <img src="http://coachxmas.samesamechina.com/img/share-3.png" alt=""/>
    </div>
</div>
</body>
</html>
<?php
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
