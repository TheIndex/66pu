<?php
/**
 * 获取商品类别
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
