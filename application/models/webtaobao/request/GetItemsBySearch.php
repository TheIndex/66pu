<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lion
 * Date: 13-7-23
 * Time: 下午2:11
 * To change this template use File | Settings | File Templates.
 */

class GetItemsBySearch {
	private $perpage = "20";
	private $apiParas;
	private $page = 1;
	private $picSize;
	private $cid;
	private static $allowSort = array("promotion_asc", "promotion_desc", "seller_credit_score_desc", "commission_rate_desc", "commission_num_desc", "commission_volume_desc",);
	private $searchKey;
	private $sort;
	private $startPromotion;
	private $endPromotion;
	private $startCredit;
	private $endCredit;
	private $startCommissionRate;
	private $endCommissionRate;
	private $startCommissionVolume;
	private $endCommissionVolume;
	private $itemType;


	/**
	 * 设置折扣价下限
	 *
	 * 范围: 0 - ∞(无穷大)
	 * @param mixed $startPromotion
	 */
	public function setStartPromotion($startPromotion) {
		$this->startPromotion = $startPromotion;
		$this->apiParas["start_promotion"]=$startPromotion;
	}

	/**
	 * 得到折扣价下限
	 *
	 * 范围: 0 - ∞(无穷大)
	 * @param mixed float
	 */
	public function getStartPromotion(){
		return $this->endPromotion;
	}

	/**
	 * 设置折扣价上限
	 *
	 * 范围:0 - ∞(无穷大) 上限少于下限会导致无数据
	 * @param mixed $endPromotion
	 */
	public function setEndPromotion($endPromotion) {
		$this->endPromotion = $endPromotion;
		$this->apiParas["end_promotion"] = $endPromotion;
	}

	/**
	 * 得到折扣价上限
	 *
	 * @return float
	 */
	public function getEndPromotion() {
		return $this->endPromotion;
	}


	/**
	 * 设置起始信用
	 *
	 * 范围: 1-20    1-5 心 6-10 钻  11-15 冠 16-20 皇冠
	 * 规则: 设置的下限必须少于上限
	 *
	 * @param mixed $startCredit
	 */
	public function setStartCredit($startCredit) {
		$this->startCredit = $startCredit;
		$this->apiParas["start_credit"]=$startCredit;
	}

	/**
	 * 得到设置的信用下限
	 *
	 *范围: 1-20    1-5 心 6-10 钻  11-15 冠 16-20 皇冠
	 *
	 * @return int
	 */
	public function getStartCredit() {
		return $this->startCredit;
	}

	/**
	 * 设置信用上限
	 *
	 * 范围: 1-20    1-5 心 6-10 钻  11-15 冠 16-20 皇冠
	 * 规则: 设置的上限必须大于下限
	 *
	 * @param mixed $endCredit
	 */
	public function setEndCredit($endCredit) {
		$this->endCredit = $endCredit;
		$this->apiParas["end_credit"]=$endCredit;
	}

	/**
	 * 得到设置的信用上限
	 *
	 * @return int
	 */
	public function getEndCredit() {
		return $this->endCredit;
	}

	/**
	 * 设置起始佣金比率
	 *
	 * 范围: 0-10000  换算为(0%-100%)
	 * 规则: 去掉百分号*100  如4% 去掉% 4 *100  传入的参数为400 下限必须少于上限
	 *
	 * @param mixed $startCommissionRate
	 */
	public function setStartCommissionRate($startCommissionRate) {
		$this->startCommissionRate = $startCommissionRate;
		$this->apiParas["start_commission_rate"]=$startCommissionRate;
	}

	/**
	 * 得到设置的佣金比例下限
	 *
	 * @return int
	 */
	public function getStartCommissionRate() {
		return $this->startCommissionRate;
	}

	/**
	 * 设置佣金比例上限
	 *
	 * 范围: 0-10000  换算为(0%-100%)
	 * 规则: 去掉百分号*100  如4% 去掉% 4 *100  传入的参数为400 上限必须大于下限
	 *
	 * @param mixed $endCommissionRate
	 */
	public function setEndCommissionRate($endCommissionRate) {
		$this->endCommissionRate = $endCommissionRate;
		$this->apiParas["end_commission_rate"] = $endCommissionRate;
	}

	/**
	 * 得到设置的佣金比例上限
	 *
	 * @return int
	 */
	public function getEndCommissionRate() {
		return $this->endCommissionRate;
	}
	/**
	 * 设置30天内的推广量下限
	 *
	 * 规则: 设置下限必须少于上限
	 * @param mixed $startCommissionVolume
	 */
	public function setStartCommissionVolume($startCommissionVolume) {
		$this->startCommissionVolume = $startCommissionVolume;
		$this->apiParas["start_commission_volume"] = $startCommissionVolume;
	}


	/**
	 * 得到设置的30天内推广量下限
	 *
	 * @return int
	 */
	public function getStartCommissionVolume() {
		return $this->startCommissionVolume;
	}

	/**
	 * 设置30天内的推广量上限
	 *
	 * 规则: 设置上限必须大于下限
	 * @param mixed $endCommissionVolume
	 */
	public function setEndCommissionVolume($endCommissionVolume) {
		$this->endCommissionVolume = $endCommissionVolume;
		$this->apiParas["end_commission_volume"] = $endCommissionVolume;
	}

	/**
	 * 得到设置的30天推广量上限
	 * @return mixed
	 */
	public function getEndCommissionVolume() {
		return $this->endCommissionVolume;
	}


	/**
	 * 设置搜索的店铺类型
	 *
	 * 范围. 不设置为全部 1为集市 2 为天猫
	 * @param mixed $itemType
	 */
	public function setItemType($itemType) {

		$this->itemType = $itemType;
		$this->apiParas["item_type"] = $itemType;
	}

	/**
	 * 得到设置的搜索店铺类型
	 * @return mixed
	 */
	public function getItemType() {
		return $this->itemType;
	}

	/**
	 * 设置排序方式
	 *
	 * 范围:
	 *      "promotion_asc",
	 *      "promotion_desc",
	 *      "seller_credit_score_desc",
	 *      "commission_rate_desc",
	 *      "commission_num_desc",
	 *      "commission_volume_desc"
	 * @param mixed $sort
	 */
	public function setSort($sort) {
		$this->sort             = $sort;
		$this->apiParas["sort"] = $sort;
	}

	/**
	 * 得到设置的排序类型
	 *
	 * @return mixed
	 */
	public function getSort() {
		return $this->sort;
	}

	/**
	 * 设置返回的图片大小
	 * 范围：
	 * 　600x600  400x400  360x360  350x350 320x320  310x310
	 * 　300x300  290x290   270x270  250x250 240x240 230x230
	 * 　220x220  210x210  200x200   190x190  180x180 170x170
	 * 　160x160  130x130   120x120  110x110   100x100 90x90
	 * 　80x80      70x70      60x60      40x40
	 * @param mixed $picSize
	 */
	public function setPicSize($picSize) {
		$this->picSize             = $picSize;
		$this->apiParas["picsize"] = $picSize;
	}

	/**
	 * 得到设置的返回图片大小
	 * @return mixed
	 */
	public function getPicSize() {
		return $this->picSize;
	}


	/**
	 * 设置搜索栏目的cid
	 *
	 * @param mixed $cid
	 */
	public function setCid($cid) {

		$this->cid             = $cid;
		$this->apiParas["cid"] = $cid;
	}

	/**
	 * 设置页数
	 *
	 * 范围 官方限制为总共400条 即页数的上限为 400/每页数量 向上取余数
	 * @param int $page
	 */
	public function setPage($page = 1) {

		$this->page             = $page;
		$this->apiParas["page"] = $page;
	}

	/**
	 * 得到设置的页数
	 *
	 * @return int
	 */
	public function getPage() {

		return $this->page;
	}

	/**
	 * 设置每页获取的数量
	 *
	 * 范围:默认为20  1<=perpage <=40
	 * @param int $perpage
	 */
	public function setPerpage($perpage = 20) {

		$this->perpage             = $perpage;
		$this->apiParas["perpage"] = $perpage;
	}

	/**
	 * 得到每页设置获取数量
	 *
	 * @return string
	 */
	public function getPerpage() {

		return $this->perpage;
	}

	/**
	 * 设置搜索关键字
	 *
	 * @param mixed $searchKey
	 */
	public function setSearchKey($searchKey) {
		$this->searchKey         = $searchKey;
		$this->apiParas["title"] = $searchKey;
	}

	/**
	 * 获得设置的搜索关键字
	 * @return mixed
	 */
	public function getSearchKey() {
		return $this->searchKey;
	}

	function check() {
		//是否为空
		RequestCheckUtil::checkEmpty($this->getSearchKey(), "field");

		//页数
		RequestCheckUtil::checkMaxValue($this->getPage(), ceil(400 / $this->getPerpage()), "page");//翻页数量
		RequestCheckUtil::checkMaxValue($this->getPerpage(), 40, "perpage");//每页显示的数量检测
		RequestCheckUtil::checkMinValue($this->getPerpage(), 0, "perpage");//每页显示的数量检测

		//折扣价检测
		RequestCheckUtil::checkMinValue($this->getStartPromotion(), 0, "start_promotion");
		RequestCheckUtil::checkMaxValue($this->getStartPromotion(),$this->getEndPromotion(),"promotion"); //检测折扣价下限是否大于上限		}

		//卖家信用检测
		RequestCheckUtil::checkMinValue($this->getStartCredit(),0,"start_credit");
		RequestCheckUtil::checkMaxValue($this->getEndCredit(),20,"end_credit");
		RequestCheckUtil::checkMaxValue($this->getStartCredit(),$this->getEndCredit(),"credit");//监测卖家信用等级是否下限大于上限

		//佣金比例检测
		RequestCheckUtil::checkMinValue($this->getStartCommissionRate(),0,"start_commission_rate");
		RequestCheckUtil::checkMaxValue($this->getStartCommissionRate(),10000,"start_commission_rate");
		RequestCheckUtil::checkMaxValue($this->getStartCommissionRate(),$this->getEndCommissionRate(),"start_commission_rate");//监测卖家信用等级是否下限大于上限

		//推广量检测
		RequestCheckUtil::checkMinValue($this->getStartCommissionVolume(), 0, "start_commission_volume");
		RequestCheckUtil::checkMaxValue($this->getStartCommissionVolume(),$this->getEndCommissionVolume(),"commission_volume"); //检测折扣价下限是否大于上限

		//推广类型
		RequestCheckUtil::checkValueWithIn($this->getItemType(), array(1,2), "item_type");

		//排序方式
		RequestCheckUtil::checkValueWithIn($this->getSort(), self::$allowSort, "sort");

	}

	function  getApiParas() {
		return $this->apiParas;
	}

	public function getApiMethodName() {
		return "searchItems";
	}

}