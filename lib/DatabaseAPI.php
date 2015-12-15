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
		$WechatAPI = new WechatAPI();
		$info = $WechatAPI->getUserInfo($openid);
		$basename = json_encode(array('name' => $info['data']['nickname']));
		$sql = "INSERT INTO `coach_xmas_info` SET `openid` = ?, nickname = ?, basename = ?, headimgurl = ?, lottery = 0";
		$res = $this->db->prepare($sql); 
		$res->bind_param("ssss", $openid, $info['data']['nickname'], $basename, $info['data']['headimgurl']);
		if ($res->execute()) {
			return $this->findUserByOpenid($openid);
		} else {
			return FALSE;
		}
	}

	/**
	 * Create user in database
	 */
	public function findUserByOpenid($openid){
		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		}
		$sql = "SELECT id,openid,basename,lottery  FROM `coach_xmas_info` WHERE `openid` = ?"; 
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $openid);
		$res->execute();
		$res->bind_result($uid, $openid, $basename, $lottery);
		if($res->fetch()) {
			$user = new stdClass();
			$user->uid = $uid;
			$user->openid = $openid;
			$user->basename = $basename;
			$user->lottery = $lottery;
			$user->status = 1;

			$_SESSION['user'] = $user;
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
	public function setPrizeRecord($uid, $lottery, $name){
		$nowtime = date("Y-m-d H:i:s");
		$sql = "INSERT INTO `coach_xmas_lottery` SET `uid` = ?, `lottery` = ?, `createtime` = ?";
		$res = $this->db->prepare($sql); 
		$res->bind_param("sss", $uid, $lottery, $nowtime);
		$res->execute();
		$sql = "UPDATE `coach_xmas_info` SET `lottery` = ? WHERE id = ?";
		$res = $this->db->prepare($sql); 
		$res->bind_param("ss", $lottery, $uid);
		$res->execute();
		$_SESSION['user']->lottery = $lottery;
		$RedisAPI = new RedisAPI();
		
	}

	/**
	 * check prize record
	 */
	public function checkLottery($uid){
		$sql = "SELECT count(*) FROM `coach_xmas_lottery` WHERE `uid` = ?"; 
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $uid);
		$res->execute();
		$res->bind_result($num);
		if($res->fetch()) {
			return $num;
		}
		return 0;
	}


}
