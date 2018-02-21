<?php
/*--------------------------
ะกอตอ๘ีพถจึฦ
qq: 996948519
---------------------------*/
define('SCRIPT','js');
require(dirname(__FILE__)."/inc/common.inc.php");
require(dirname(__FILE__)."/inc/caiji.class.php");
$v_config=require(VV_DATA."/config.php");
require(dirname(__FILE__)."/inc/robot.php");

if($_SERVER['QUERY_STRING']){
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
if ($v_config['sifton'] && OoO0o0O0o()) {
	$sifturl = explode('[cutline]', $v_config['sifturl']);
	foreach($sifturl as $k => $vo) {
		if ($vo == $GLOBALS['geturl']) {
			exit();
		} 
	} 
}
if ($v_config['sifton'] && OoO0o0O0o()) {
	$sifturl = explode('[cutline]', $v_config['sifturl']);
	foreach($sifturl as $k => $vo) {
		if ($vo == $GLOBALS['geturl']) {
			exit();
		} 
	} 
}
require(VV_DATA."/rules.php");
?>