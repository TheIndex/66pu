<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lion
 * Date: 13-7-26
 * Time: 下午4:54
 * To change this template use File | Settings | File Templates.
 */

class GetItemcatsByCid {
	private $cid;
	private $apiParas;

	/**
	 * @return mixed
	 */
	public function getApiParas() {
		return $this->apiParas;
	}

	function check() {
		RequestCheckUtil::checkMinValue($this->getCid(),0, "cid");
	}

	/**
	 * @param mixed $cid
	 */
	public function setCid($cid) {
		$this->cid = $cid;
		$this->apiParas["cid"]=$cid;
	}

	/**
	 * @return mixed
	 */
	public function getCid() {
		return $this->cid;
	}

	public function getApiMethodName() {
		return "getItemCategory";
	}

}