<?php 
$weixin_id = '3736f002c80bf8bfe5aa9ad41c87c984';
$access_token = '08ecb2077e158fd621a1f175e22442e8';
$api_url = 'http://oauth.curio.im/v1/wx/web/register?access_token='. $access_token;
// 参数数组
$data = array(
        'callback_url' => 'http://coach.samesamechina.com/getdata.php',
		'redirect_url' => 'http://coach.samesamechina.com/getopenid.php',
		'scope' => 'userinfo'
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
echo $return;
exit;