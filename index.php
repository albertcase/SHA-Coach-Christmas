<?php
/*
session_start();
include_once ('./config/database.php');
include_once ('./config/Pdb.php');
include_once ('./config/emoji.php');
if (!isset($_SESSION['user_id'])) {
    Header("Location:http://oauth.curio.im/v1/wx/web/auth/d36cfb23-9430-4b11-80e5-ae6b0c706ab8");
    exit;
}
//判断是否关注
$info = file_get_contents("http://api.curio.im/v2/wx/users/".$_SESSION['openid']."?access_token=08ecb2077e158fd621a1f175e22442e8");
$info = json_decode($info, true);

$db = Pdb::getDb();
$sql="select * from (SELECT * from `coach_xmas_lottery` WHERE lottery =1) a left join `coach_xmas_info` b on a.uid = b.id";
$lotteryList = $db->getAll($sql,true);
*/
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
    <link rel="stylesheet" type="text/css" href="css/emoji.css" />
</head>
<body>
<div class="loading">
    <div class="inner">
        <div class="l-logo">
            <img src="img/loading-logo.png" alt=""/>
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
        <div class="logo">
            <img src="img/logo.png" alt=""/>
        </div>
        <!-- qrcode-->
        <?php if($info['data']['subscribe']==1) {?>
        <section class="qrcode">
            <img src="img/qrcode.png" alt=""/>
        </section>
        <?php }?>
        <!-- Homepage 我要摇奖 -->
        <section class="pin pin-1">
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
                        <?php
                        if (!$lotteryList) {
                            echo '<li>目前还没有人中奖</li>';
                        } else {
                            for ($i = 0; $i < count($lotteryList); $i++) {
                                $name = json_decode($lotteryList[$i]['basename'], true);
                                echo '<li>'.emoji_unified_to_html($name['name']).'已经中奖Coach礼包</li>';
                            }
                        }
                        ?>
                        <li>amber已经中奖1 </li>
                        <li>amber已经中奖1 </li>
                        <li>amber已经中奖1 </li>
                    </ul>
                </div>
            </div>
            <div class="p1-3 buttons">
                <!--我要摇奖-->
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
                    <!--再摇一次-->
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
                        <!--提交-->
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
                    还可以领取COACH圣诞礼券哦
                </div>
                <div class="buttons gocoupon">
                    <!--立刻去领券-->
                </div>
            </div>
        </section>

        <!-- 活动细则-->
        <section class="pin pin-7">
            <div class="inner">
                <div class="back">返回</div>
                <h3 class="title">活动细则</h3>
                <div class="line">
                    <img src="img/line.png" alt="">
                </div>
                <p class="content">
                    参与本活动无需以购买蔻驰产品或服务为前提。购买我们的产品或服务并不会增加你在本次活动中的获胜机会。
                    <br>
                    <br>

                    1. 参与资格: 任何年满18岁的中国大陆公民均有资格参与蔻驰微信“摇一摇，遇见COACH圣诞好礼”活动（以下简称本活动）。
                    蔻驰在中国的雇员、经理和各级代表及其直系亲属（父母，配偶，子女，兄弟姐妹）及家庭成员不得参与本次活动。本次活动将严格遵守中华人民共和国的相关法律及法规。
                    参与本活动表示你同意无条件完全遵守本活动细则以及活动主办方的相关决定。奖品的获取是在参与者完成了所有规定任务之后按完成时间优先排序选取的。

                    <br>
                    <br>
                    2. 活动主办方: 蔻驰贸易（上海）有限公司
                </p>
                <div class="buttons p1-3">
                    <!--我要摇奖-->
                </div>
            </div>
        </section>
        <div class="share">
            <img src="img/share-3.png" alt=""/>
        </div>
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