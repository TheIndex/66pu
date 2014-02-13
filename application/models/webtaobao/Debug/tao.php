<?php
error_reporting(0);
require_once "../CuzyClient.php";

$urlstr = trim($_GET["url"]);

$cuzyClient = new CuzyClient();
$jumpRst = $cuzyClient->jump($urlstr);
if($jumpRst['html'])
	echo $jumpRst['html'];
else
	echo 'fail';
