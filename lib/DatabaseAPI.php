<?php
/**
 * DatabaseAPI class
 */
class DatabaseAPI {

	private $db;

	/**
	 * Initialize
	 */
	public function __construct(){
		$connect = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		$this->db = $connect;
	}

	/**
	 * Create user in database
	 */
	public function insertUser($openid){
		$info = file_get_contents("http://api.curio.im/v2/wx/users/" . $openid . "?access_token=" . CURIO_TOKEN);
		$info = json_decode($info, true);
		$basename = json_encode(array('name' => $info['data']['nickname']));
		$sql = "INSERT INTO `coach_xmas_info` SET `openid` = ?, nickname = ?, basename = ?, headimgurl = ?, status = 1";
		$res = $this->db->prepare($sql); 
		$res->bind_param("ssss", $openid, $info['data']['nickname'], $basename, $info['data']['headimgurl']);
		if($res->execute()) 
			return $this->findUserByOpenid($openid);
		else 
			return FALSE;
	}

	/**
	 * Create user in database
	 */
	public function findUserByOpenid($openid){
		$sql = "SELECT id,openid,status  FROM `coach_xmas_info` WHERE `openid` = ?"; 
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $openid);
		$res->execute();
		$res->bind_result($uid, $openid, $status);
		if($res->fetch()) {
			$user = new stdClass();
			$user->uid = $uid;
			$user->openid = $openid;
			$user->status = $status;
			return $user;
		}
		return NULL;
	}

	/**
	 * load prize record
	 */
	public function loadLotteryList(){
		$sql="SELECT basename FROM  `coach_xmas_info` where id in (SELECT id FROM `coach_xmas_lottery` WHERE `lottery` =1)";
		$res = $this->db->query($sql);
		if ($res->num_rows<=0) {
			return false;
		}
		$data = $res->fetch_array(MYSQLI_NUM);
		return $data;
		
	}

	/**
	 * finish user info
	 */
	public function finishInfo($name, $mobile, $uid){
		$sql="UPDATE `coach_xmas_info` SET `name` = ?, `mobile` = ? WHERE id = ?";
		$res = $this->db->prepare($sql);
		$res->bind_param("sss", $name, $mobile, $uid);
		if($res->execute()) {
			return TRUE;
		} else {
			return FALSE;
		}
		
	}

	/**
	 * Add prize record
	 */
	public function setPrizeRecord($uid, $lottery){
		$nowtime = NOWTIME;
		$sql = "INSERT INTO `coach_xmas_lottery` SET `uid` = ?, `lottery` = ?, `created` = ?";
		$res = $this->db->prepare($sql); 
		$res->bind_param("sss", $uid, $lottery, $nowtime);
		if($res->execute()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
