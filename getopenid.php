<?php 
session_start();
include_once ('./config/database.php');
include_once ('./config/Pdb.php');
$_POST = $_REQUEST;
$db = Pdb::getDb();
$_SESSION['openid'] = $_GET['openid'];
$user = $db->getRow("SELECT * FROM `coach_xmas_info` WHERE `openid` = " . $db->quote($_SESSION['openid']), true);
if (!$user) {
	$sql = "INSERT INTO `coach_xmas_info` SET `openid` = " . $db->quote($_SESSION['openid']) . ",status = 1";
	$db->execute($sql);
	$_SESSION['user_id'] = $db->lastInsertId;
} else {
	$_SESSION['user_id'] = $user['id'];
}
Header("Location:/");
exit;