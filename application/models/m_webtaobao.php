<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lion
 * Date: 13-8-7
 * Time: 下午1:49
 * To change this template use File | Settings | File Templates.
 */

class M_webtaobao extends CI_Model {
	private $cuzyClient;

	function __construct() {
		parent::__construct();
		$this->config->load('site_info');

		define('PU_HTTP_PROXY', $this->config->item('http_proxy'));

		require "webtaobao/CuzyClient.php";
		$cuzyClient            = new CuzyClient();
		$cuzyClient->appkey    = $this->config->item('cuzy_appkey');
		$cuzyClient->appsecret = $this->config->item('cuzy_secretkey');
		$cuzyClient->webFrom   = '66pu';
		$this->cuzyClient = $cuzyClient;
	}

	function getCats($parentid) {
		$cuzyClient = $this->cuzyClient;
		$cuzyGetCats           = $cuzyClient->load_api("GetItemcatsByCid");
		$cuzyGetCats->setCid($parentid);

		return $cuzyClient->advExecute($cuzyGetCats);
	}

	/**
	 * 搜索条目
	 *
	 * @param string  $keyword  搜索关键词
	 * @param integer $cid      淘宝的后台类目ID
	 *
	 * @return String $resp XML字符串
	 */
	function searchItem($keyword, $cid, $condition=array()) {
		$cuzyClient = $this->cuzyClient;
		$cuzyDataBySearch      = $cuzyClient->load_api("GetItemsBySearch");
		$cuzyDataBySearch->setRedirectByWebRoot(dirname(BASEPATH));

		$cuzyDataBySearch->setCid($cid); //分类
		$cuzyDataBySearch->setSearchKey($keyword); //关键词

		$cuzyDataBySearch->setPicSize("230x230");
		$cuzyDataBySearch->setSort("seller_credit_score_desc");
		$cuzyDataBySearch->setStartCommissionRate(100);
		$cuzyDataBySearch->setEndCommissionRate("5000");
		
		$page = max($condition['page'], 1);
		$prepage = $condition['prepage'] ? $condition['prepage'] : 40;
		
		$cuzyDataBySearch->setPage($page);
		$cuzyDataBySearch->setPerpage($prepage);

		$resp = $cuzyClient->advExecute($cuzyDataBySearch);

		return $resp;
	}

	function getItemByTheme($page,$perpage,$themeid){
		$cuzyClient = $this->cuzyClient;
		$cuzyThemeData      = $cuzyClient->load_api("GetItemsByTheme");
		$cuzyThemeData->setRedirectByWebRoot(dirname(BASEPATH));
		$cuzyThemeData->setPage($page);
		$cuzyThemeData->setPerpage($perpage);
		$cuzyThemeData->setPicSize("230x230");
		$cuzyThemeData->setThemeId($themeid);
		$resp = $cuzyClient->advExecute($cuzyThemeData);
		return $resp;
	}

}
