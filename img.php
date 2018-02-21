<?php
/*--------------------------
小偷网站定制
qq: 996948519
---------------------------*/
define('SCRIPT','img');
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
	exit('err2');
}
$caiji_config=require(VV_DATA."/config/{$collectid}.php");
if(!is_resdomain($GLOBALS['geturl'])){
	exit('err3');
}
$parse_url=parse_url($GLOBALS['geturl']);

$itype = substr(basename($parse_url['path']), -4, 4);
$ext=str_replace('.','',$itype);
if($v_config['web_debug']=="on" && @$_GET['debug']=='true'){
	$GLOBALS['geturl']=str_replace('?debug=true','',$GLOBALS['geturl']);
}else{
	if(in_array($ext,array('jpg','jpeg','png','gif','bmp','ttf','ico'))){
		header("Content-Type: image/{$ext}; charset=UTF-8");
	}else{
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".basename($parse_url['path']).";"); 
	}
}
if ($v_config['sifton'] && OoO0o0O0o()) {
	$sifturl = explode('[cutline]', $v_config['sifturl']);
	foreach($sifturl as $k => $vo) {
		if ($vo == $GLOBALS['geturl']) {
			header("Content-type: image/png");
			exit();
		} 
	} 
} 
$cacheid=md5($GLOBALS['geturl']);
$cachefile=getimgcachefile($cacheid,$ext);
$cachetime=$v_config['imgcachetime'];
//初始化插件
define('VV_PLUS',true);
$GLOBALS['isplus']=false;
plus_run('init');
plus_run('before_get_img');
if($v_config['imgcache']){
	if( OoO0o0O0o() && !is_file ($cachefile) || (@filemtime($cachefile)+($cachetime*3600))<= time ()){
		run_time(true);
		$imgbin=$caiji->geturl($GLOBALS['geturl']);
		$GLOBALS['debug'][] = '使用缓存：否';
		$GLOBALS['debug'][]='采集用时：'.run_time().'s';
		plus_run('before_cache_img');
		if($cachetime && !empty($imgbin)){
			write($cachefile,$imgbin);
		}
	}else{
		$imgbin=file_get_contents($cachefile);
		$GLOBALS['debug'][] = '使用缓存：是';
		$GLOBALS['debug'][]='缓存路径：'.$cachefile;
	}
	echo $imgbin;
	//调试模式
	if($v_config['web_debug']=="on"){
		echo "\r\n/*---调试信息 start---\r\n".implode("\r\n",$GLOBALS['debug'])."\r\n---调试信息 end---*/\r\n";
	}
}else{
	header("Location: {$GLOBALS['geturl']}");
	exit;
}