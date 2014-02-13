<?php
/**
 * Request cache
 */

class Cache {
	public $expireDay;
	public $dir;

	public function __construct($dir='') {
		if($dir)
			$this->dir = $dir. '/cuzy_cache/'.Date('Ymd', time());
		else
			$this->dir = dirname(__FILE__) . '/cache/'.Date('Ymd', time());
		$this->expireDay = 1;
		$this->createDir($this->dir);
	}

	public function getHttpCache($params) {
		if(rand(1, 10) >= 8)
			$this->clearCache();
		if(is_array($params))
			$params = http_build_query($params);
		$cache_file = $this->dir .'/'. md5($params);
		if(is_file($cache_file))
			$data = file_get_contents($cache_file);
		else 
			return '';
		return $data;
	}
	public function setHttpCache($params, $data) {
		if(is_array($params))
			$params = http_build_query($params);
		$cache_file = $this->dir .'/'. md5($params);
		file_put_contents($cache_file, $data);
	}
	/* 
	 * 清理无用的数据缓存
	 * cc：一次清理一个缓存文件夹
	 */
	public function clearCache() {
		$cache_dir = dirname($this->dir);
		$today = intval(basename($this->dir));
		$expiresDir = $today - $this->expireDay;
		if($dh = opendir($cache_dir)){
			while ($file = readdir($dh)) {
				if ($file != "." && $file != ".." && $file <= $expiresDir) {
					$this->deleteDir($cache_dir . '/' . $file);
					return true;
				}
			}
		}
		return true;
	}
	public function createDir($dir) {
		if(!is_dir($dir))
			mkdir($dir, 0755, true);
	}
	// 删除目录
	public function deleteDir($dir) {
		if (!file_exists($dir)) {
			return false;
		} 
		if($dh = opendir($dir)){
			while ($file = readdir($dh)) {
				if ($file != "." && $file != "..") {
					$fullpath = $dir . "/" . $file;
					if (!is_dir($fullpath)) {
						unlink($fullpath);
					} else {
						del_session($fullpath);
					}
				}
			}
			closedir($dh);
		}
		rmdir($dir);
		return true;
	}
} 
