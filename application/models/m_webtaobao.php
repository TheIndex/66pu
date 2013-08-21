<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lion
 * Date: 13-8-7
 * Time: 下午1:49
 * To change this template use File | Settings | File Templates.
 */

class M_webtaobao extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->config->load('site_info');

		define('CUZY_APPKEY', $this->config->item('cuzy_appkey'));
		define('CUZY_SECRETKEY', $this->config->item('cuzy_secretkey'));

		define('PU_HTTP_PROXY', $this->config->item('http_proxy'));

		include "webtaobao/CuzyApi.php";
	}

	function getCats($parentid) {
		$cuzyClient            = new CuzyClient();
		$cuzyClient->appkey    = CUZY_APPKEY;
		$cuzyClient->appsecret = CUZY_SECRETKEY;
		$cuzyGetCats           = $cuzyClient->load_api("GetItemcatsByCid");
		$cuzyGetCats->setCid($parentid);

		//50011740 男鞋
		//16 女装/女士精品
		//50006842 箱包皮具/热销女包/男包
		//50012029 运动鞋new
		//30 男装
		return $cuzyClient->advExecute($cuzyGetCats);
	}

	/**
  * 根据条目ID获取更详细的信息，包括图片列表
  *
  * @param integer $item_id  条目ID
  * @return string $resp 包含图片列表的XML
  */
// function getItemInfo($item_id){
//     if($item_id == ''){
//         return '';
//     }else{
//         $c = new TopClient;
//         $c->appkey = APPKEY;
//         $c->secretKey = SECRETKEY;
//         $req = new ItemGetRequest;
//         //prop_imgs 选择颜色的时候出现的图
//         //item_imgs->item_img->url 所有的大图
//         //desc 好像很厉害的样子
//         $req->setFields("prop_img.url,item_img.url,nick,num_iid");
//         //  $req->setFields("detail_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_url,num,valid_thru,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,approve_status,postage_id,product_id,auction_point,property_alias,item_img,prop_img,sku,video,outer_id,is_virtual");
//         $req->setNumIid($item_id);
//         $resp = $c->execute($req);
//         return $resp;
//     }
// }
	/**
	 * 搜索条目
	 *
	 * @param string  $keyword  搜索关键词
	 * @param integer $cid      淘宝的后台类目ID
	 *
	 * @return String $resp XML字符串
	 */
	function searchItem($keyword, $cid) {
//		$keyword = iconv("UTF-8", "GBK", $keyword);
//		var_dump($keyword,$cid);
		$cuzyClient            = new CuzyClient();
		$cuzyClient->appkey    = CUZY_APPKEY;
		$cuzyClient->appsecret = CUZY_SECRETKEY;
		$cuzyDataBySearch      = $cuzyClient->load_api("GetItemsBySearch");

		$cuzyDataBySearch->setCid($cid); //分类
		$cuzyDataBySearch->setSearchKey($keyword); //关键词

		$cuzyDataBySearch->setPicSize("230x230");
		$cuzyDataBySearch->setSort("seller_credit_score_desc");
		$cuzyDataBySearch->setStartCommissionRate(500);
		$cuzyDataBySearch->setEndCommissionRate("5000");
		$cuzyDataBySearch->setItemType(2);
		$cuzyDataBySearch->setPage(1);
		$cuzyDataBySearch->setPerpage(40);

		$resp = $cuzyClient->advExecute($cuzyDataBySearch);

		return $resp;
	}

}