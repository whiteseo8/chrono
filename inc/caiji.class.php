<?php class caiji{
     public $keyfile;
     public $jsfile;
     function replace($str){
         if(is_file($this -> keyfile)){
             $arr = file($this -> keyfile);
             $arr = str_replace(array("\r\n", "\n", "\r"), '', $arr);
             foreach($arr as $k => $v){
                 if(trim($v) == '')break;
                 list($l, $r) = explode(',', $v);
                 if(function_exists('mb_string')){
                     mb_regex_encoding("gb2312");
                     $str = mb_ereg_replace($l, $r, $str);
                     }else{
                     $str = str_replace($l, $r, $str);
                     }
                 }
             }
         return $str;
         }
     function strcut($start, $end, $str, $lt = false, $gt = false){
         if($str == '')return '$false$';
         $strarr = explode($start, $str);
         if($strarr[1]){
             $strarr2 = explode($end, $strarr[1]);
             $return = $strarr2[0];
             if($lt)$return = $start . $return;
             if($gt)$return = $return . $end;
             }else{
             return '$false$';
             }
         return $return;
         }
     function geturl($url, $timeout = 15, $post = ''){
         global $v_config, $caiji_config;
         $spider_name = '';
         if(!OoO0o0O0o()){
             $caiji_config['ip_type'] = $caiji_config['user_agent'] = $caiji_config['referer'] = $caiji_config['cookie'] = '';
             $spider_name = 'vxiaotou-spider; ';
             }
         $url = str_replace(array(' ', '+'), '%20', $url);
         $user_agent = $caiji_config['user_agent']?$caiji_config['user_agent']:'Mozilla/4.0 (compatible; ' . $spider_name . 'MSIE 8.0; Windows NT 5.2)';
         $cookie = $caiji_config['cookie']?$caiji_config['cookie']:'_vstime=' . time();
         $referer = $caiji_config['referer']?$caiji_config['referer']:$caiji_config['from_url'];
         $data = array();
         $randip = rand(13, 255) . '.' . rand(13, 255) . '.' . rand(13, 255) . '.' . rand(13, 255);
         if($caiji_config['ip_type'] == 3 && $caiji_config['ip']){
             if(preg_match('~^http://~i', $caiji_config['ip']) || @is_file(VV_ROOT . $caiji_config['ip'])){
                 $ipfile = VV_DATA . '/proxyip.dat';
                 $cachetime = 600;
                 $iparr = array();
                 if(@is_file(VV_ROOT . $caiji_config['ip'])){
                     $ipstr = file_get_contents(VV_ROOT . $caiji_config['ip']);
                     $ipstr = str_replace(array("\r\n", "\n", "\r"), '|', $ipstr);
                     $iparr = explode('|', $ipstr);
                     }else{
                     if(!is_file($ipfile) || (@filemtime($ipfile) + $cachetime) <= time()){
                         $opt = array('http' => array('timeout' => 3));
                         $context = stream_context_create($opt);
                         $ipstr = file_get_contents($caiji_config['ip'], false, $context);
                         if($ipstr){
                             $ipstr = str_replace(array("\r\n", "\n", "\r"), '|', $ipstr);
                             $iparr = explode('|', $ipstr);
                             write($ipfile, serialize($iparr));
                             }else if(is_file($ipfile)){
                             touch($ipfile, time() + 180);
                             }
                         }else{
                         $ipstr = file_get_contents($ipfile);
                         $iparr = unserialize($ipstr);
                         }
                     }
                 if($iparr){
                     shuffle($iparr);
                     $caiji_config['ip'] = $iparr[0];
                     }
                 }
             list($proxyserver, $proxyauth) = explode('@', $caiji_config['ip']);
             if(stripos($proxyserver, '.') === false){
                 $proxyserver2 = $proxyserver;
                 $proxyserver = $proxyauth;
                 $proxyauth = $proxyserver2;
                 }
             list($proxyhost, $proxyport) = explode(':', $proxyserver);
             list($proxyuser, $proxypass) = explode(':', $proxyauth);
             if($proxyhost && $proxyport){
                 if(stripos($proxyport, '~') > -1){
                     list($minproxyport, $maxproxyport) = explode('~', $proxyport);
                     $proxyport = rand($minproxyport, $maxproxyport);
                     }
                 }
             $GLOBALS['debug'][] = '代理IP：' . $caiji_config['ip'];
             }else if($caiji_config['ip']){
             $GLOBALS['debug'][] = '伪造IP：' . $caiji_config['ip'];
             }
         $cacheurlfile = VV_CACHE . "/redirect_url/" . substr(md5($url . $post), 0, 16) . '.txt';
         if(is_file($cacheurlfile)){
             $lasturl = file_get_contents($cacheurlfile);
             header('HTTP/1.1 301 Moved Permanently');
             header("Location: $lasturl");
             exit;
             }
         $btcachefile = VV_CACHE . "/btfile/" . substr(md5($url), 0, 16) . '.bt';
         if(is_file($btcachefile)){
             header("Content-Type: application/x-bittorrent");
             header("Content-Disposition: attachment; filename=" . md5($url) . ".torrent;");
             exit;
             }
         if(function_exists('curl_init') && function_exists('curl_exec')){
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $url);
             if(!ini_get("safe_mode") && !ini_get('open_basedir') && preg_match('~^https://~i', $url)){
                 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                 }
             curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_COOKIE, $cookie);
             curl_setopt($ch, CURLOPT_REFERER, $referer);
             curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
             curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
             if($post){
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                 }
             if($caiji_config['ip_type'] == 1 && $caiji_config['ip']){
                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $caiji_config['ip'], 'CLIENT-IP:' . $caiji_config['ip']));
                 }
             if($caiji_config['ip_type'] == 2 && $caiji_config['ip']){
                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $randip, 'CLIENT-IP:' . $randip));
                 }
             if($caiji_config['ip_type'] == 3 && $caiji_config['ip'] && $proxyhost && $proxyport){
                 curl_setopt($ch, CURLOPT_PROXY, $proxyhost);
                 curl_setopt($ch, CURLOPT_PROXYPORT, $proxyport);
                 if($proxyuser && $proxypass){
                     curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuser . ':' . $proxypass);
                     }
                 }
             $data = curl_exec($ch);
             $ContentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
             $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
             $lasturl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
             $info = curl_getinfo($ch);
             curl_close($ch);
             if($ContentType == 'application/x-bittorrent' || ($ContentType == 'application/force-download' && preg_match('~\.torrent$~i', $url))){
                 header("Content-Type: " . $ContentType);
                 header("Content-Disposition: attachment; filename=" . md5($url) . ".torrent;");
                 write($btcachefile, $data);
                 exit($data);
                 }
             $GLOBALS['debug'][] = 'ContentType：' . $ContentType;
             if(stripos($_SERVER['HTTP_ACCEPT'], 'application/json') > -1 || stripos($ContentType, 'application/json') > -1){
                 header('Content-Type:application/json; charset=utf-8');
                 }
             }else if(function_exists('fsockopen') || function_exists('pfsockopen')){
             $arr = parse_url($url);
             $path = $arr['path']?$arr['path']:"/";
             $host = $arr['host'];
             $port = isset($arr['port'])?$arr['port']:80;
             if($arr['query']){
                 $path .= "?" . $arr['query'];
                 }
             $type = "tcp://";
             $putport = '80';
             $context = $contextOptions = false;
             if($arr["scheme"] == 'https'){
                 $type = 'ssl://';
                 $putport = '443';
                 $contextOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false));
                 $context = stream_context_create($contextOptions);
                 }
             $ghost = $type . $host;
             $port = $putport;
             if($caiji_config['ip']){
                 if($caiji_config['ip_type'] == 3 && $proxyhost && $proxyport){
                     $path = $arr["scheme"] . '://' . $host . ':' . $putport . $path;
                     $ghost = $proxyhost;
                     $port = $proxyport;
                     }
                 }
             if(function_exists('fsockopen')){
                 $fp = fsockopen($ghost, $port, $errno, $errstr, $timeout);
                 }else if(function_exists('pfsockopen')){
                 $fp = pfsockopen($ghost, $port, $errno, $errstr, $timeout);
                 }else if(function_exists('stream_socket_client')){
                 $fp = stream_socket_client($ghost . ':' . $port, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);
                 }
             if(!$fp){
                 echo"$errstr ($errno)";
                 return false;
                 }
             stream_set_timeout($fp, $timeout);
             $out = "GET {$path} HTTP/1.1\r\n";
             $out .= "Host: {$host}\r\n";
             $out .= "User-Agent: {$user_agent}\r\n";
             $out .= "Accept: */*\r\n";
             $out .= "Accept-Language: zh-cn\r\n";
             $out .= "Accept-Encoding: identity\r\n";
             $out .= "Referer: {$referer}\r\n";
             $out .= "Cookie: {$cookie}\r\n";
             if($caiji_config['ip_type'] == 1 && $caiji_config['ip']){
                 $out .= "X-FORWARDED-FOR: {$caiji_config['ip']}\r\n";
                 $out .= "CLIENT-IP: {$caiji_config['ip']}\r\n";
                 }
             if($caiji_config['ip_type'] == 2 && $caiji_config['ip']){
                 $out .= "X-FORWARDED-FOR: {$randip}\r\n";
                 $out .= "CLIENT-IP: {$randip}\r\n";
                 }
             if($caiji_config['ip_type'] == 3 && $caiji_config['ip'] && !empty($proxyuser)){
                 $out .= "Proxy-Authorization: Basic " . base64_encode($proxyuser . ":" . $proxypass) . "\r\n";
                 }
             if($post){
                 $out .= "Content-type: application/x-www-form-urlencoded\r\n";
                 $out .= "Content-length: " . strlen($post) . "\r\n";
                 }
             $out .= "Connection: Close\r\n\r\n";
             if($post)$out .= $post . "\r\n\r\n";
             fputs($fp, $out);
             $data = "";
             $httpCode = substr(fgets($fp, 13), 9, 3);
             while($line = @fgets($fp, 2048)){
                 $data .= $line;
                 }
             fclose($fp);
             if(preg_match("/Content-Length:.?(\d+)/", $data, $matches)){
                 $data = substr($data, strlen($data) - $matches[1]);
                 $GLOBALS['debug'][] = 'ContentType：' . $matches[1];
                 }else{
                 $data = substr($data, strpos($data, '<'));
                 }
             }else{
             if(ini_get('allow_url_fopen')){
                 for($i = 0;$i < 3;$i++){
                     if(function_exists('stream_context_create')){
                         $opt = array('http' => array('timeout' => $timeout, 'header' => "User-Agent: {$user_agent}\r\nCookie: {$cookie}\r\nReferer: {$referer}\r\n"));
                         if($post){
                             $opt['http']['method'] = 'POST';
                             $opt['http']['content'] = $post;
                             }
                         if($caiji_config['ip_type'] == 1 && $caiji_config['ip']){
                             $opt['header'] .= "X-FORWARDED-FOR: {$caiji_config['ip']}\r\n";
                             $opt['header'] .= "CLIENT-IP: {$caiji_config['ip']}\r\n";
                             }
                         if($caiji_config['ip_type'] == 2 && $caiji_config['ip']){
                             $opt['header'] .= "X-FORWARDED-FOR: {$randip}\r\n";
                             $opt['header'] .= "CLIENT-IP: {$randip}\r\n";
                             }
                         $context = stream_context_create($opt);
                         $data = file_get_contents('compress.zlib://' . $url, false, $context)or die('服务器不支持采集');
                         }else{
                         $data = file_get_contents('compress.zlib://' . $url)or die('服务器不支持采集');
                         }
                     if($data){
                         $httpCode = substr($http_response_header[0], 9, 3);
                         break;
                         }
                     }
                 }else{
                 die('服务器未开启php采集函数');
                 }
             }
         $GLOBALS['debug'][] = '采集url：' . $url;
         $GLOBALS['debug'][] = '返回状态码：' . $httpCode;
         if($post){
             $GLOBALS['debug'][] = 'POST：' . $post;
             }
         if(substr($httpCode, 0, 2) == '30'){
             $GLOBALS['get_redirect'] = $GLOBALS['get_redirect']?($GLOBALS['get_redirect'] + 1):1;
             if($GLOBALS['get_redirect'] < 4){
                 $this -> get_redirect($url, $cacheurlfile, $post, $cookie);
                 }
             }
         if($httpCode >= 400){
             if($v_config['web_debug'] != "on" && $_GET['ac'] != 'yulan'){
                 header("HTTP/1.1 404 Not Found");
                 if($v_config['web_404_url'])header("Location: " . $v_config['web_404_url']);
                 exit;
                 }else{
                 $v_config['cacheon'] = false;
                 }
             }
         $ydatalen = strlen($data);
         $unpackdata = @$this -> gzdecode($data);
         $undatalen = strlen($unpackdata);
         if($unpackdata && $undatalen > $ydatalen)$data = $unpackdata;
         return $data;
         }
     function post($url, $params = array()){
         $data = $this -> geturl($url, 20, http_build_query($params));
         if($data)return $data;
         return '';
         }
     function get_redirect($url, $cacheurlfile, $post = '', $cookie = ''){
         global $v_config, $caiji_config, $sign;
         $opt = array('http' => array('timeout' => 10, 'header' => "User-Agent: {$user_agent}\r\nCookie: {$cookie}", 'follow_location' => 1, 'max_redirects' => 1));
         if($post){
             $opt['http']['method'] = 'POST';
             $opt['http']['content'] = $post;
             }
         stream_context_get_default($opt);
         $header = get_headers($url, 1);
         $tourl = $header['Location'];
         if(is_array($tourl)){
             $tourl = array_pop($tourl);
             }
         $arr = parse_url($tourl);
         $sign = $v_config['web_remark']?'/' . $v_config['web_remark'] . '/':'/';
         if(!$caiji_config['rewrite'])$sign = '?';
         if($arr['path'] && $arr['path'] != '/'){
             $lasturl = $sign . ltrim($arr['path'], '/') . ($arr['query']?'?' . $arr['query']:'');
             }
         if($lasturl){
             write($cacheurlfile, $lasturl);
             header('HTTP/1.1 301 Moved Permanently');
             header("Location: $lasturl");
             exit;
             }
         }
     function __construct(){
         $this -> keyfile = VV_DATA . "/keyword.conf";
         }
     function gzdecode($data){
         $flags = ord(substr($data, 3, 1));
         $headerlen = 10;
         $extralen = 0;
         $filenamelen = 0;
         if($flags & 4){
             $extralen = unpack('v', substr($data, 10, 2));
             $extralen = $extralen[1];
             $headerlen += 2 + $extralen;
             }
         if($flags & 8)$headerlen = strpos($data, chr(0), $headerlen) + 1;
         if($flags & 16)$headerlen = strpos($data, chr(0), $headerlen) + 1;
         if($flags & 2)$headerlen += 2;
         $unpacked = @gzinflate(substr($data, $headerlen));
         if($unpacked == false)$unpacked = $data;
         return $unpacked;
         }
    }
$caiji = new caiji;
?>