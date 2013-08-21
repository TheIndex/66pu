<?php
/**
 * Created by PhpStorm.
 * User: Lion
 * Date: 13-8-19
 * Time: 上午10:43
 */

class Format {
	protected 	$response;
	protected   $apiName;

	public function __construct($resp,$apiName){
		$this->response = $resp;
		$this->apiName  = $apiName;
	}

	public function getErrorResponse(){
		return $this->response->error_response;
	}

	public function __call($name,$arg){
		if(strtolower(substr($name,0,3)) == "get"){
			$str = substr($name,3);
			if($this->getErrorResponse()->code ==0){
				$apiName = $this->apiName .$str;
				if(method_exists($this,$apiName)){

					return $this->$apiName($this->response);
				}else{
					return new stdClass();
				}
			}else{
				return $this->getErrorResponse();
			}
		}
	}
	public function GetItemcatsByCidData(){
		return $this->response->itemcats_get_response->item_cats->item_cat;
	}

	public function GetItemsBySearchData(){

		return $this->response->cuzy_items_get_response->cuzy_items->item;
	}

	public function GetItemsBySearchCount(){

		return $this->response->cuzy_items_get_response->cuzy_items->count;
	}

	public function GetItemsByThemeData(){
		return $this->response->cuzy_items_get_response->cuzy_items->item;
	}
	public function GetItemByThemeCount(){
		return $this->response->cuzy_items_get_response_cuzy_items->count;
	}
} 