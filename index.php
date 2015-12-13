<?php
if (!isset($_SESSION['user_id'])) {
    Header("Location:http://oauth.curio.im/v1/wx/web/auth/d36cfb23-9430-4b11-80e5-ae6b0c706ab8");
    exit;
}
//判断是否关注
$info = file_get_contents("http://api.curio.im/v2/wx/users/".$_SESSION['openid']."?access_token=08ecb2077e158fd621a1f175e22442e8");
$info = json_decode($info, true);

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>遇见COACH圣诞好礼</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" >
    <link rel="stylesheet" type="text/css" href="css/screen.css"/>
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" href="apple-touch-icon.png" class="__web-inspector-hide-shortcut__">
    <script type="text/javascript" src="js/jquery.min.js" ></script>
    <!-- production-->
    <!--<script type="text/javascript" src="dist/js/rem.js"></script>-->
    <!--<script type="text/javascript" src="dist/js/common.js"></script>-->
    <!-- development-->
    <script type="text/javascript" src="js/jweixin.js"></script>
    <script type="text/javascript" src="js/service.js"></script>
    <script type="text/javascript" src="js/shake.js"></script>
    <script type="text/javascript" src="js/marquee.js"></script>
    <script type="text/javascript" src="js/wxshare.js"></script>
    <script type="text/javascript" src="js/rem.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<div class="loading" style="display: none;">
    loading...
</div>
<div class="wrapper">
    <div class="wrap">
        <div class="logo">
            <img src="img/logo.png" alt=""/>
        </div>
        <!-- Homepage 我要摇奖 -->
        <section class="pin pin-1 current">
            <div class="p1-4">
                <h3 class="title">
                    感谢您<br>
                    在这一年的持续支持
                </h3>
                <p class="p1-des">
                    您一如既往的关注更是<br>
                    COACH前进的动力
                    <br>
                    <br>
                    <span class="small-font">在温馨的圣诞节，我们为您准备了惊喜好礼，拿起手机摇一摇，遇见最贴心的COACH圣诞礼遇</span>
                </p>

            </div>
            <div class="marquee-wrap">
                <div class="p1-2" id="marquee">
                    <ul class="list">
                        <li>amber已经中奖1 </li>
                        <li>amber已经中奖1 </li>
                        <li>amber已经中奖1 </li>
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
            <div class="inner">
                <div class="p2-1 animate-gif">
                    <img src="img/gif/animate2.gif" alt=""/>
                </div>
                <div class="p2-t1">
                    <span class="tt">再</span>摇一摇
                </div>
                <div class="p2-2">
                    遇见 . 圣诞好礼
                </div>
                <div class="p2-3">
                    好包好礼赠不停
                </div>
            </div>
        </section>

        <!-- 摇一摇成功页面 -->
        <section class="pin pin-3">
            <div class="inner">
                <div class="p3-1 animate-gif">
                    <img src="img/gif/animate3.gif" alt=""/>
                </div>
                <!-- get prize-->
                <div class="prize prize-1">
                    <div class="pz-1">
                        <span class="p3-t1">恭喜你摇到了</span>
                        价值1000元的COACH好礼
                    </div>
                    <div class="p3-5 buttons">
                        <!--留下你的获奖信息-->
                    </div>
                </div>
                <!-- 1000元prize-->
                <div class="prize prize-2">
                    <div class="pz-2">
                        <span class="p3-t1">恭喜你摇到了</span>
                        COACH圣诞钟情礼券
                    </div>
                    <div class="gocoupon buttons">
                        <!-- 立刻去领券 -->
                    </div>
                </div>
            </div>
        </section>

        <!-- 摇一摇失败页面 -->
        <section class="pin pin-4">
            <div class="inner">
                <div class="p3-1 animate-gif">
                    <img src="img/gif/animate.gif" alt=""/>
                </div>
                <!-- 1000元prize-->
                <div class="prize no-prize">
                    <span class="p3-t1">很遗憾</span>
                    你没有摇到礼物
                </div>
                <div class="p4-5 buttons">
                    再摇一次
                </div>
            </div>
        </section>

        <!-- 填写个人信息-->
        <section class="pin pin-5">
            <div class="inner">
                <p class="p4-txt">
                    圣诞老人准备出发了
                    <strong>请完善以下信息</strong>
                </p>
                <div class="line">
                    <img src="img/line.png" alt=""/>
                </div>
                <form action="post" id="form-contact">
                    <div class="input-box input-box-name">
                        <input type="text" name="name" class="input-name" placeholder="姓名/NAME"/>
                    </div>
                    <div class="input-box input-box-phone">
                        <input type="number" name="phone" class="input-phone" placeholder="手机/MOBILE PHONE"/>
                    </div>
                    <div class="buttons btn-submit">
                        提交
                    </div>
                </form>
            </div>
        </section>

        <!-- 礼物页面-->
        <section class="pin pin-6">
            <div class="inner">
                <div class="p6-1 animate-gif">
                    <img src="img/gif/animate4.gif" alt=""/>
                </div>
                <div class="p6-2">
                    提交成功
                </div>
                <div class="line">
                    <img src="img/line.png" alt=""/>
                </div>
                <div class="p6-3">
                    返回首页<br>
                    还可以领取现金抵用券哦
                </div>
                <div class="buttons btn-back">
                    返回
                </div>
            </div>
        </section>

    </div>
</div>
<?php
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
?>
<script>
var cardListJSON = <?php echo json_encode($cardList)?>;
function addCard(i) {
    wx.addCard({
        cardList: [{
            cardId: cardListJSON[i-1].cardId,
            cardExt: '{"timestamp":"'+cardListJSON[i-1].cardExt.timestamp+'","signature":"'+cardListJSON[i-1].cardExt.signature+'"}'
        }],
        success: function(res) {
            var cardList = res.cardList;
            //alert(JSON.stringfiy(res));
        },
        fail: function(res) {
            //alert(JSON.stringfiy(res));
        },
        complete: function(res) {
            //alert(JSON.stringfiy(res));
        },
        cancel: function(res) {
            //alert(JSON.stringfiy(res));
        },
        trigger: function(res) {
            //alert(JSON.stringfiy(res));
        }
    }); 

};
</script>
</body>
</html>