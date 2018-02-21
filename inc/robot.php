<?php if(!defined('VV_INC'))exit(header("HTTP/1.1 403 Forbidden"));
if($v_config['robotlogon'] !== '0'){
     $ServerName = $_SERVER["SERVER_NAME"];
     $ServerPort = $_SERVER["SERVER_PORT"];
     $serverip = $_SERVER["REMOTE_ADDR"];
     $url_this = "http://" . $_SERVER['HTTP_HOST'] . get_thisurl();
     $Url = "http://" . $ServerName;
     If($ServerPort != "80"){
         $Url = $Url . ":" . $ServerPort;
         }else{
         $Url = $_SERVER['HTTP_REFERER'];
         }
     $GetLocationURL = $Url;
     $agent1 = $_SERVER["HTTP_USER_AGENT"];
     $agent = strtolower($agent1);
     $Bot = "";
     if(strpos($agent, 'http://') > -1 && preg_match('#bot|spider|crawl|nutch|lycos|robozilla|slurp|search|seek|archive#i', $agent)){
         $Bot = "其它蜘蛛";
         }
     if(stripos($agent, "googlebot") > -1){
         $Bot = "Google";
         }
     if(stripos($agent, "mediapartners-google") > -1){
         $Bot = "Google Adsense";
         }
     if(stripos($agent, "baiduspider") > -1){
         $Bot = "Baidu";
         }
     if(stripos($agent, "360spider") > -1){
         $Bot = "360搜索";
         }
     if(stripos($agent, "soso") > -1){
         $Bot = "soso";
         }
     if(stripos($agent, "sogou") > -1){
         $Bot = "Sogou";
         }
     if(stripos($agent, "yahoo") > -1){
         $Bot = "Yahoo!";
         }
     if(stripos($agent, "msn") > -1){
         $Bot = "MSN";
         }
     if(stripos($agent, "ia_archiver") > -1){
         $Bot = "Alexa";
         }
     if(stripos($agent, "iaarchiver") > -1){
         $Bot = "Alexa";
         }
     if(stripos($agent, "sohu") > -1){
         $Bot = "Sohu";
         }
     if(stripos($agent, "sqworm") > -1){
         $Bot = "AOL";
         }
     if(stripos($agent, "yodaoBot") > -1){
         $Bot = "Yodao";
         }
     if(stripos($agent, "iaskspider") > -1){
         $Bot = "新浪爱问";
         }
     if(stripos($agent, "Yisouspider") > -1){
         $Bot = "神马搜索";
         }
     if($v_config['ban_zhizhu_on'] && $v_config['ban_zhizhu_list']){
         $v_config['ban_zhizhu_list'] = explode(',', $v_config['ban_zhizhu_list']);
         foreach($v_config['ban_zhizhu_list']as $k => $vo){
             if(stripos($agent, $vo) > -1 || ($vo == 'other' && $Bot == "其它蜘蛛")){
                 exit(header("HTTP/1.1 403 Forbidden"));
                 }
             }
         }
     $shijian = date("Y-m-d H:i:s");
     define('IP_FILE', VV_DATA . "/zhizhu.txt");
     $ip = getip() . '---' . $Bot . '---' . $url_this . '---' . $shijian;
     if(SCRIPT == 'item' && !empty($Bot))exit(header("HTTP/1.1 403 Forbidden"));
     if(!empty($Bot) && !is_file(IP_FILE)){
         write(IP_FILE, $ip);
         }else if(!empty($Bot) && is_file(IP_FILE)){
         $arr = file(IP_FILE);
         $i = count($arr);
         $arr = array_slice($arr, 0, 10000);
         $iplist = $ip . "\r\n" . implode("", $arr);
         write(IP_FILE, $iplist);
         }
    }
function get_thisurl(){
     if(!empty($_SERVER["REQUEST_URI"])){
         $scrtName = $_SERVER["REQUEST_URI"];
         $nowurl = $scrtName;
         }else{
         $scrtName = $_SERVER["PHP_SELF"];
         if(empty($_SERVER["QUERY_STRING"])){
             $nowurl = $scrtName;
             }else{
             $nowurl = $scrtName . "?" . $_SERVER["QUERY_STRING"];
             }
         }
     return $nowurl;
    }
?>