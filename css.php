<?php

define('SCRIPT','css');
require(dirname(__FILE__)."/inc/common.inc.php");
require(dirname(__FILE__)."/inc/caiji.class.php");
$v_config=require(VV_DATA."/config.php");
require(dirname(__FILE__)."/inc/robot.php");

if(isset($_GET['code']) && $_GET['code']){
	$GLOBALS['geturl']=base64_decode(strrev(rawurldecode($_GET['code'])));
	$collectid=isset($_GET['tid'])?$_GET['tid']:'';
}else if($_SERVER['QUERY_STRING']){
	list($query,)=explode('?',$_SERVER['QUERY_STRING']);
	list($query,)=explode('&',$query);
	list($collectid,$GLOBALS['geturl'])=explode('|',decode_source($query));
}else{
	exit('err');
}
$collectid=(int)$collectid;
if(!$collectid){
	exit('err');
}
$caiji_config=require(VV_DATA."/config/{$collectid}.php");
if(!preg_match('~^https?://~i',$GLOBALS['geturl'])){
	exit('err');
}
require(VV_DATA."/rules.php");
?>