<?php 
session_start();
include_once ('./config/database.php');
include_once ('./config/Pdb.php');
$_POST = $_REQUEST;
$db = Pdb::getDb();
$_SESSION['openid'] = $_GET['openid'];
$user = $db->getRow("SELECT * FROM `coach_xmas_info` WHERE `openid` = " . $db->quote($_SESSION['openid']), true);
if (!$user) {
	$info = file_get_contents("http://api.curio.im/v2/wx/users/".$_SESSION['openid']."?access_token=08ecb2077e158fd621a1f175e22442e8");
	$info = json_decode($info, true);
	$basename = json_encode(array('name' => $info['data']['nickname']));
	$sql = "INSERT INTO `coach_xmas_info` SET `openid` = " . $db->quote($_SESSION['openid']) . ",nickname = " . $db->quote($info['data']['nickname']) . ",basename = " . $db->quote($basename) . ",headimgurl = " . $db->quote($info['data']['headimgurl']) . " ,status = 1";
	$db->execute($sql);
	$_SESSION['user_id'] = $db->lastInsertId;
} else {
	$_SESSION['user_id'] = $user['id'];
}
Header("Location:/");
exit;