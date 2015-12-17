<?php
/**
 * RedisAPI class
 */
class RedisAPI {

	private $redis;

	/**
	 * Initialize
	 */
	public function __construct(){
		$this->redis = new Redis();
		$this->redis->connect(REDIS_HOST, REDIS_PORT);
	}

	/**
	 * get prize record
	 */
	public function getLotteryList(){
   		$arList = $this->redis->lrange("coach_lottery_list", 0 ,-1);
   		return $arList;
	}


	/**
	 * set prize record
	 */
	public function setLotteryList($nickname){
   		$this->redis->lPush("coach_lottery_list", $nickname);
   		$arList = $this->redis->lrange("coach_lottery_list", 0 ,-1);
   		return $arList;
	}

	public function refreshList(){
		$this->redis->delete("coach_lottery_list");
		$DatabaseAPI = new DatabaseAPI();
		$rs = $DatabaseAPI->loadLotteryList();
		for ($i = 0; $i < count($rs); $i++) {
			$this->redis->lPush("coach_lottery_list", $rs[$i]['nickname']);
		}
		$arList = $this->redis->lrange("coach_lottery_list", 0 ,-1);
		return $arList;
	}


}
