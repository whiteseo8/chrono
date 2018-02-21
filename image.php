<?php
require(dirname(__FILE__)."/inc/define.inc.php");
require(VV_INC . '/define.php');
require(VV_INC . '/function.php');
$v_config = require(VV_DATA . "/config.php");
$collectid = $v_config['collectid'];
$caiji_config = require(VV_DATA . "/config/{$collectid}.php");
if ($v_config['web_urlencode'] && $_SERVER['QUERY_STRING']) {
    list($_SERVER['QUERY_STRING'],) = explode('?', $_SERVER['QUERY_STRING']);
    //$_SERVER['QUERY_STRING'] = preg_replace('~\.(jpg|css|js|' . $v_config['web_urlencode_suffix'] . ')$~i', '', $_SERVER['QUERY_STRING']);
    $_SERVER['QUERY_STRING'] = decode_id($_SERVER['QUERY_STRING']);
}
list($_SERVER['QUERY_STRING'],) = explode('#', $_SERVER['QUERY_STRING']);
$_SERVER['QUERY_STRING'] = convert_query($_SERVER['QUERY_STRING'], $caiji_config['charset']);

$from_url = $caiji_config['from_url'];
$isouturl = false;
if (isset($GLOBALS['geturl'])) {
    $from_url = $GLOBALS['geturl'];
    $isouturl = true;
}
define('ISOUTURL', $isouturl);
$parse_url = parse_url($from_url);
$port = isset($parse_url['port']) ? $parse_url['port'] : '';
$server_url = $parse_url['scheme'] . '://' . $parse_url['host'];
$server_url2 = '//' . $parse_url['host'];
if ($port) {
    $server_url = $server_url . ':' . $port;
    $server_url2 = $server_url2 . ':' . $port;
}
$str = '';
$sign = $v_config['web_remark'] ? '/' . $v_config['web_remark'] . '/' : '/';
$temp_url = parse_url($v_config['web_url']);
define('WEB_ROOT', substr($temp_url['path'], 0, -1));
if (substr($_SERVER['QUERY_STRING'], 0, 1) == '/') {
    $_SERVER['QUERY_STRING'] = substr($_SERVER['QUERY_STRING'], 1);
}
if ($_SERVER["PATH_INFO"]) {
    $GLOBALS['geturl'] = $server_url . $_SERVER["PHP_SELF"] . ($_SERVER["QUERY_STRING"] ? '?' . $_SERVER["QUERY_STRING"] : '');
} else if (!isset($GLOBALS['geturl'])) {
    $GLOBALS['geturl'] = $server_url . '/' . $_SERVER['QUERY_STRING'];
}

$url =  $GLOBALS['geturl'];

$save_dir = VV_ROOT.dirname($_SERVER['REQUEST_URI']);
$filename=basename($url);

if(!file_exists($save_dir)){
    mkdir($save_dir,0755,true);
}

$lujing = $save_dir.'/'.$filename;

$user_agent = 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)';
$referer = 'https://www.baidu.com';
$headerArr = array('CLIENT-IP:220.181.108.95','CLIENT-IP:220.181.108.95');


//--------------curlобтьм╪ф╛---------------------------------
$ch = curl_init();
$timeout = 30;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $referer);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
$file = curl_exec($ch);
$ext = substr(strrchr($filename, '.'), 1);

if (strnatcasecmp($ext,'jpg')==0||strnatcasecmp($ext,'jepg')){
    header('Content-type:image/jpeg');
    echo $file;
}

elseif (strnatcasecmp($ext,'png')==0){
    header('Content-type:image/'.$ext);
    echo $file;

}

elseif (strnatcasecmp($ext,'bmp')==0){
    header('Content-type:image/x-ms-bmp');
    echo $file;

}

elseif (strnatcasecmp($ext,'gif')==0){
    header('Content-type:image/'.$ext);
    echo $file;
}

curl_close($ch);

$fp2=@fopen($lujing,'a');
fwrite($fp2,$file);
fclose($fp2);
?>