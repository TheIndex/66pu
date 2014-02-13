<?php
class CuzyClient
{
	public $appkey;
	public $appsecret;

	public $debug = 1;
	public $cache = false;
	public $webFrom = 'cuzySDK';
	public $gatewayUrl = "http://www.cuzy.com/webapi/";

	/** 是否打开入参check**/
	public $checkRequest = true;
	protected $signMethod = "md5";
	protected $apiVersion = "1";
	protected $sdkVersion = "cuzy-sdk-php-2013-10-25";
	private $baseDir;

	public function __construct() {
		$this->baseDir = dirname(__FILE__) . "/";
		spl_autoload_register(array($this, "autoLoader"));
	}
	protected function autoLoader($name) {
		$file = $this->baseDir.'/'.$name . ".php";
		if(is_file($file))
			require_once($file);
	}
	public function jump($urlstr) {
		$req_url = dirname($this->gatewayUrl)."?g=stat&m=stat&a=jump_html"."&url=".$urlstr;
		$resp    = $this->curl($req_url);

		$jumpArray  = json_decode($resp, TRUE);
		return $jumpArray;

	}

	protected function generateSign($params)
	{
		ksort($params);

		$stringToBeSigned = $this->appsecret;
		foreach ($params as $k => $v)
		{
			if("@" != substr($v, 0, 1))
			{
				$stringToBeSigned .= "$k$v";
			}
		}
		unset($k, $v);
		$stringToBeSigned .= $this->appsecret;

		return strtoupper(md5($stringToBeSigned));
	}

	public function curl($url, $postFields = null) {
		$paramsArr = array();
		if($postFields) {
			$paramStr = http_build_query($postFields);
			$url = $url.'?'.$paramStr;
		}
		$reponse = file_get_contents($url);

		return $reponse;
	}

	protected function logCommunicationError($apiName, $requestUrl, $errorCode, $responseTxt)
	{
	}
	public function advExecute($request,$session=null){
		$apiName = get_class($request);
		$resp = $this->execute($request,$session);
		/* if($apiName == 'GetGrouponBySearch') {
			return $resp;
		} */
		$formatData = new Format($resp,$apiName);
		return $formatData;
	}
	public function execute($request, $session = null)
	{
		if($this->checkRequest) {
			try {
				$request->check();
			} catch (Exception $e) {
				$result = array();
				$result['code'] = $e->getCode();
				$result['msg'] = $e->getMessage();
				return $result;
			}
		}
		$sysParams = array();
		//获取参数
		$apiParams = $request->getApiParas();
		$apiParams["appkey"] = $this->appkey;
		$apiParams["appsecret"] = $this->appsecret;
		$apiParams["debug"] = $this->debug;
		$apiParams["webfrom"] = $this->webFrom;

		//系统参数放入GET请求串
		$requestUrl = $this->gatewayUrl .$request->getApiMethodName()."/";

		foreach ($sysParams as $sysParamKey => $sysParamValue)
		{
			$requestUrl .= "$sysParamKey/" . urlencode($sysParamValue) . "/";
		}
		$requestUrl = substr($requestUrl, 0, -1);
		//发起HTTP请求
		try
		{
			if($this->cache) {
				$cache = new Cache();
				$resp = $cache->getHttpCache($apiParams);
			}
			if(empty($resp)) {
				$resp = $this->curl($requestUrl,  $apiParams);
			} else {
				$readCacheFlag = 1;
			}
		}
		catch (Exception $e)
		{
			$this->logCommunicationError($request->getApiMethodName(),$requestUrl,"HTTP_ERROR_" . $e->getCode(),$e->getMessage());
			$result = array();
			$result['code'] = $e->getCode();
			$result['msg'] = $e->getMessage();
			return $result;
		}

		//解析TOP返回结果
		$respWellFormed = false;
		$respObject = json_decode($resp, true);
		if (null !== $respObject)
		{
			$respWellFormed = true;
		}

		//返回的HTTP文本不是标准JSON或者XML，记下错误日志
		if (false === $respWellFormed)
		{
			$this->logCommunicationError($sysParams["method"],$requestUrl,"HTTP_RESPONSE_NOT_WELL_FORMED",$resp);
			$result= array();
			$result['code'] = 0;
			$result['msg'] = "HTTP_RESPONSE_NOT_WELL_FORMED";
			return $result;
		}

		//如果TOP返回了错误码，记录到业务错误日志中
		if (isset($respObject['error_response']['code']) && $respObject['error_response']['code'] != 0)
		{
			unset($respObject['data']);
			unset($respObject['expection']);
		} else {
			if($this->cache && $readCacheFlag == 0) {
				$cache = new Cache();
				$cache->setHttpCache($apiParams, $resp);
			}
		}

		return $respObject;
	}

	public function exec($paramsArray)
	{
		if (!isset($paramsArray["method"]))
		{
			trigger_error("No api name passed");
		}
		$inflector = new LtInflector;
		$inflector->conf["separator"] = ".";
		$requestClassName = ucfirst($inflector->camelize(substr($paramsArray["method"], 7))) . "Request";
		if (!class_exists($requestClassName))
		{
			trigger_error("No such api: " . $paramsArray["method"]);
		}

		$session = isset($paramsArray["session"]) ? $paramsArray["session"] : null;

		$req = new $requestClassName;
		foreach($paramsArray as $paraKey => $paraValue)
		{
			$inflector->conf["separator"] = "_";
			$setterMethodName = $inflector->camelize($paraKey);
			$inflector->conf["separator"] = ".";
			$setterMethodName = "set" . $inflector->camelize($setterMethodName);
			if (method_exists($req, $setterMethodName))
			{
				$req->$setterMethodName($paraValue);
			}
		}
		return $this->execute($req, $session);
	}
	public function load_api($api_name){
		include_once $this->baseDir . "request/".$api_name.".php";
		return new $api_name;
	}
}
