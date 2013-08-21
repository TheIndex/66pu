<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lion
 * Date: 13-7-23
 * Time: 下午2:11
 * To change this template use File | Settings | File Templates.
 */

class GetItemsByTheme {
		private $themeId;
		private $picSize;

	/**
	 * @param mixed $picSize
	 */
	public function setPicSize($picSize) {
		$this->picSize = $picSize;
		$this->apiParas["picsize"]=$picSize;
	}
		private $perpage = "20";

	    private $page = 1;
		private $apiParas;

	/**
	 * @return mixed
	 */
	public function getApiParas() {
		return $this->apiParas;
	}

	/**
	 * @return int
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * @param mixed $themeId
	 */
	public function setThemeId($themeId) {
		$this->themeId = $themeId;
		$this->apiParas["themeid"] = $themeId;
	}

	/**
	 * @return mixed
	 */
	public function getThemeId() {

		return $this->themeId;
	}

	/**
	 * @return string
	 */
	public function getPerpage() {
		return $this->perpage;
	}

	/**
	 * @param int $page
	 */
	public function setPage($page) {
		$this->page = $page;
	}

	/**
	 * @param string $perpage
	 */
	public function setPerpage($perpage) {
		$this->perpage = $perpage;
		$this->apiParas["perpage"] = $perpage;
	}


	function check(){
		RequestCheckUtil::checkEmpty($this->getThemeId(),"field");

	}

	public function getApiMethodName()
	{
		return "getThemeItems";
	}

}