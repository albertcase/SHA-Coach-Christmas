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
		$user = $this->findUserByOpenid($openid);
		if ($user) {
			return $user;
		}
		$sql = "INSERT INTO `coach_xmas_info` SET `openid` = ?, lottery = 0";
		$res = $this->db->prepare($sql); 
		$res->bind_param("s", $openid);
		if ($res->execute()) {
			return $this->findUserByOpenid($openid);
		} else {
			return FALSE;
		}
	}

	public function regUser($openid, $nickname, $headimgurl) {
		if ($this->findUserByOauth($openid)) {
			return TRUE;
		}
		$sql = "INSERT INTO `coach_xmas_oauth` SET `openid` = ?, nickname = ?, basename = ?, headimgurl = ?";
		$res = $this->db->prepare($sql); 
		$basename = json_encode(array('name' => $nickname));
		$res->bind_param("ssss", $openid, $nickname, $basename, $headimgurl);
		if ($res->execute()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Create user in database
	 */
	public function findUserByOauth($openid){
		$sql = "SELECT id  FROM `coach_xmas_oauth` WHERE `openid` = ?"; 
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $openid);
		$res->execute();
		$res->bind_result($uid);
		if($res->fetch()) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Create user in database
	 */
	public function findUserByOpenid($openid){
		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		}
		$sql = "SELECT id, openid, lottery FROM `coach_xmas_info` WHERE `openid` = ?"; 
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $openid);
		$res->execute();
		$res->bind_result($uid, $openid, $lottery);
		if($res->fetch()) {
			$user = new stdClass();
			$user->uid = $uid;
			$user->openid = $openid;
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
		$sql="SELECT nickname FROM  `coach_xmas_oauth` a, `coach_xmas_info` b where b.openid = a.openid and b.lottery=1";
		$res = $this->db->query($sql);
		$data = $res->fetch_array(MYSQLI_ASSOC);
		return $data;
		
	}

	/**
	 * finish user info
	 */
	public function finishInfo($name, $mobile, $uid){
		$sql="INSERT INTO `coach_xmas_list` SET `name` = ?, `mobile` = ?, uid = ?";
		$this->db->query('set names utf8');
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
	public function setPrizeRecord($uid, $lottery) {
		$sql = "UPDATE `coach_xmas_info` SET `lottery` = ? WHERE id = ?";
		$res = $this->db->prepare($sql); 
		$res->bind_param("ss", $lottery, $uid);
		$res->execute();
		$_SESSION['user']->lottery = $lottery;
		if ($lottery == 1) {
			$sql = "SELECT nickname FROM `coach_xmas_oauth` WHERE `openid` = ?"; 
			$res = $this->db->prepare($sql);
			$res->bind_param("s", $_SESSION['user']->openid);
			$res->execute();
			$res->bind_result($nickname);
			$res->fetch();
			$RedisAPI = new RedisAPI();
			$RedisAPI->setLotteryList($nickname);
		}
	}

	/**
	 * check prize record
	 */
	public function totalcount(){
		$sql = "SELECT count(*) FROM `coach_xmas_info` WHERE `lottery` = 1"; 
		$res = $this->db->prepare($sql);
		$res->execute();
		$res->bind_result($num);
		if($res->fetch()) {
			return $num;
		}
		return 0;
	}




}
