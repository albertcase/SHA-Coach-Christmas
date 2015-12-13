<?php
session_start();
include_once ('./config/database.php');
include_once ('./config/Pdb.php');
$_POST = $_REQUEST;
$db = Pdb::getDb();
if (isset($_POST['model'])) {
	switch ($_POST['model']) {
		case 'status':
			if (!isset($_SESSION['user_id'])) {
			    print json_encode(array("code"=>0,"msg"=>"请先登录"));
			    exit;
			}
			break;
			
		case 'saveinfo':
			if (!isset($_SESSION['user_id'])) {
			    print json_encode(array("code"=>0,"msg"=>"请先登录"));
			    exit;
			}
			$tag = false;
			$name = isset($_POST['name']) ? $_POST['name'] : $tag = true;
			$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : $tag = true;
			if ($tag) {
				print json_encode(array("code"=>2,"msg"=>"请填写必填项"));
				exit;
			}

			$sql="UPDATE `coach_xmas_info` SET `name` = ".$db->quote($name).", `mobile`=".$db->quote($mobile)." WHERE `id` = ".intval($_SESSION['user_id']);
			$db->execute($sql);
			print json_encode(array("code"=>1,"msg"=>'提交成功'));
			exit;
			break;

		case 'lottery':
			if (!isset($_SESSION['user_id'])) {
			    print json_encode(array("code"=>0,"msg"=>"请先登录"));
			    exit;
			}
			$rand = rand(1,3);
			if($rand == 1) {
				//1000元
				print json_encode(array("code"=>1,"msg"=>"礼品"));
			    exit;
			} else if ($rand == 2) {
				//卡券
				print json_encode(array("code"=>2,"msg"=>"卡券"));
			    exit;
			} else {
				//未中奖
				print json_encode(array("code"=>3,"msg"=>"未中奖"));
			    exit;
			}
			break;

		case 'share':

		default:
			# code...
			print json_encode(array("code"=>9999,"msg"=>"No Model"));
			exit;
			break;
	}
}		
print "error";
exit;
