<?php
ini_set("display_errors", 1);
Session_Start();
require_once dirname(__FILE__) . "/conf/config.php";
$RedisAPI = new RedisAPI();
$list = $RedisAPI->getLotteryList();
var_dump($list);
?> 
 <!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>遇见COACH圣诞好礼</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" >
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" type="text/css" href="/dist/style.css"/>
    <script type="text/javascript" src="/dist/js/jrem.js"></script>
    <script type="text/javascript">
    </script>
</head>
<body>
<div class="wrapper">
    <div class="wrap">
        <!-- qrcode-->
        <section class="qrcode">
            <img src="/img/qrcode.png" alt=""/>
        </section>
    </div>
</div>
</body>
</html>