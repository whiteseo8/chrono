<?php if(!defined('VV_INC'))exit(header("HTTP/1.1 403 Forbidden"));
define('VV_VERSION', '4.2');
require(VV_INC . '/define.php');
require(VV_INC . '/function.php');
define('RUN_TIME', debug_time());
define('MEMORY_LIMIT_ON', function_exists('memory_get_usage'));
if(MEMORY_LIMIT_ON)$GLOBALS['_start_memory'] = memory_get_usage();
if(isset($_SERVER['HTTP_X_ORIGINAL_URL'])){
     $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
    }
if(isset($_SERVER['HTTP_X_REWRITE_URL'])){
     $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
    }
$version = " " . VV_VERSION;
if(!function_exists('getallheaders')){
     function getallheaders(){
         foreach($_SERVER as $name => $value){
             if(substr($name, 0, 5) == 'HTTP_'){
                 $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                 }
             }
         return $headers;
         }
    }
$action = isset($_GET['action'])?$_GET['action']:'';
switch($action){
case 'c1':echo OoO0o0O0o();
     break;
case 'c2':$file = VV_DATA . "/" . OoO0oOo0o();
     if(is_file($file) && stripos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) > -1)@unlink($file);
     break;
case 'c3':$file = VV_DATA . "/" . OoO0oOo0o();
     $code = isset($_POST['code'])?trim($_POST['code']):'';
     $result = OoO0o0O0o($code);
     if($result)Ooo0o0O00($code);
     echo $result;
     break;
case 'c4':echo OoO0o0O0o(0, 1);
     break;
case 'c5':$file = isset($_GET['file'])?trim($_GET['file']):die('miss file');
     $code = @file_get_contents(VV_ROOT . "/public/js/" . $file);
     $key = isset($_GET['key'])?trim($_GET['key']):die('miss key');
     $result = Oo00oOO0o($code, $key);
     header("Content-type: text/javascript; charset=gbk");
     echo $result . ';var submit=\'<tr class="firstalt"><td colspan="2" align="center"><input class="bginput" type="submit" name="submit" value=" 提交 ">&nbsp;&nbsp;<input class="bginput" type="reset" name="Input" value=" 重置 "></td></tr>\';';
     break;
    }
$randtime = time();
$tips = OoO0o0O0o()?'<span style="color: green">已授权</span>':'<span style="color: #FF0000">未授权(<a href="javascript:" onclick="o();">录入授权码</a>)</span> 功能受限制，授权开放全部功能';
$welcome = "您当前{$tips}，使用版本为：<span style='color: #FF6600'>{$version}</span>";
$temp_head = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="../public/css/admin.css">
<link href="../public/css/jquery.css" rel="stylesheet" type="text/css">
<link href="../public/css/base.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../public/js/jquery.js"></script>
<script type="text/javascript" src="../public/js/jquery-ui.min.js"></script>

<link href="../public/multi-select/css/multi-select.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../public/multi-select/js/jquery.multi-select.js"></script>
<style type="text/css">
.error_msg{
	color:red;
}
.success_msg{
	color:green;
}
</style>
</head>';
define('ADMIN_HEAD', $temp_head);
$linkwordfile = VV_DATA . "/linkword.conf";
$adsfile = VV_DATA . "/ads.conf";
$config_ads = unserialize(file_get_contents($adsfile));
$config_ads2 = array();
if($config_ads){
foreach($config_ads as $k => $vo){
$config_ads2[$vo['mark']] = $vo['body'];
}
}
function get_ads_body($mark){
global $config_ads;
foreach($config_ads as $k => $vo){
if($vo['mark'] == $mark){
     return $vo['body'];
    }
}
}
$IIIIIIIIIIl1 = VV_DATA . "/" . OoO0oOo0o();
$vipcode = '';
if(is_file($IIIIIIIIIIl1)){
$vipcode = file_get_contents($IIIIIIIIIIl1);
}
function plus_run($func = ''){
global $caiji_config;
if(!isset($GLOBALS['plusclass'])){
$plusArr = explode(',', $caiji_config['plus']);
foreach($plusArr as $k => $vo){
     $plusfile = VV_DATA . '/plus/' . $vo . '/' . $vo . '.class.php';
     if(is_file($plusfile)){
         require($plusfile);
         $GLOBALS['plusclass'][$vo] = new $vo;
         $GLOBALS['isplus'] = true;
         }
    }
}
if(!$GLOBALS['isplus']){
$GLOBALS['plusclass'] = array();
}
if($func == '' || empty($GLOBALS['plusclass'])){
return '';
}
foreach($GLOBALS['plusclass']as $k => $vo){
if(method_exists($vo, $func)){
     $vo -> $func();
    }
}
}
?>