<?php if (!defined('VV_INC')) exit(header("HTTP/1.1 403 Forbidden"));
banip();
$GLOBALS['debug'] = array();
if ($v_config['web_debug'] == "on") {
    @ini_set('display_errors', 'On');
} else {
    error_reporting(0);
}
include(VV_INC . "/delcache.php");
$ac = isset($_GET['ac']) ? $_GET['ac'] : '';
$collectid = $v_config['collectid'];
if ($ac == 'yulan') {
    $collectid = intval(@$_GET['collectid']);
    $v_config['cacheon'] = false;
} else if ($_COOKIE['collectid'] != '') {
    $collectid = intval($_COOKIE['collectid']);
    $v_config['cacheon'] = false;
}
$caiji_config = require(VV_DATA . "/config/{$collectid}.php");
if ($v_config['web_urlencode'] && $_SERVER['QUERY_STRING']) {
    list($_SERVER['QUERY_STRING'],) = explode('?', $_SERVER['QUERY_STRING']);
    //$_SERVER['QUERY_STRING'] = preg_replace('~\.(jpg|css|js|' . $v_config['web_urlencode_suffix'] . ')$~i', '', $_SERVER['QUERY_STRING']);
    $_SERVER['QUERY_STRING'] = decode_id($_SERVER['QUERY_STRING']);
}
list($_SERVER['QUERY_STRING'],) = explode('#', $_SERVER['QUERY_STRING']);
$_SERVER['QUERY_STRING'] = convert_query($_SERVER['QUERY_STRING'], $caiji_config['charset']);
$charset = (SCRIPT == 'search' && $caiji_config['search_charset']) ? $caiji_config['search_charset'] : $caiji_config['charset'];
$temp = array();
if (!empty($_POST)) {
    foreach ($_POST as $k => $vo) {
        $k = convert_query($k, $charset);
        $temp[$k] = convert_query($vo, $charset);
    }
}
$_POST = $temp;
$temp = array();
foreach ($_GET as $k => $vo) {
    $k = convert_query($k, $charset);
    $temp[$k] = convert_query($vo, $charset);
}
$_GET = $temp;
$caiji_config['resdomain'] = $caiji_config['resdomain'] ? $caiji_config['resdomain'] : $caiji_config['other_imgurl'];
$from_url = $caiji_config['from_url'];
$isouturl = false;
if (isset($GLOBALS['geturl'])) {
    $from_url = $GLOBALS['geturl'];
    $isouturl = true;
}
if ($ac == 'yulan') {
    if (isset($_GET['url'])) {
        $caiji_config['from_url'] = $_GET['url'];
    }
    $GLOBALS['geturl'] = $caiji_config['from_url'];
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
if (!$caiji_config['rewrite'] || !OoO0o0O0o()) {
    $sign = '?';
    if (SCRIPT == 'search') $sign = WEB_ROOT . '/?';
}
if (empty($_SERVER['QUERY_STRING'])) {
    $cachefile = VV_CACHE . '/index.html';
    $cachetime = $v_config['indexcache'];
    $GLOBALS['geturl'] = $from_url;
} else {
    if (substr($_SERVER['QUERY_STRING'], 0, 1) == '/') {
        $_SERVER['QUERY_STRING'] = substr($_SERVER['QUERY_STRING'], 1);
    }
    if ($_SERVER["PATH_INFO"]) {
        $GLOBALS['geturl'] = $server_url . $_SERVER["PHP_SELF"] . ($_SERVER["QUERY_STRING"] ? '?' . $_SERVER["QUERY_STRING"] : '');
    } else if (!isset($GLOBALS['geturl'])) {
        $GLOBALS['geturl'] = $server_url . '/' . $_SERVER['QUERY_STRING'];
    }
    $cacheid = md5($GLOBALS['geturl']);
    $cachefile = getcachefile($cacheid);
    $cachetime = $v_config['othercache'];
}
if (SCRIPT == 'search') {
    if (!empty($_POST)) {
        $searchurl = $caiji_config['search_url'];
    } else {
        unset($_GET['action']);
        $getstr = http_build_query($_GET);
        $search_sign = stripos($caiji_config['search_url'], '?') > -1 ? '&' : '?';
        $searchurl = $caiji_config['search_url'] . $search_sign . $getstr;
    }
    if (substr($searchurl, 0, 7) != 'http://' && substr($searchurl, 0, 8) != 'https://') {
        $searchurl = $server_url . '/' . ltrim($searchurl, '/');
    }
    $cacheid = !empty($_POST) ? md5($searchurl . http_build_query($_POST)) : md5($searchurl);
    $cachefile = getcachefile($cacheid);
    $cachetime = $v_config['othercache'];
}
$extarr = array('php', 'html', 'shtml', 'htm', 'jsp', 'xhtml', 'asp', 'aspx', 'txt', 'action', 'xml', 'css', 'js', 'gif', 'jpg', 'jpeg', 'png', 'bmp', 'ico', 'swf');
foreach ($extarr as $vo) {
    $GLOBALS['geturl'] = str_replace('.' . $vo . '&', '.' . $vo . '?', $GLOBALS['geturl']);
}
if (SCRIPT != 'search' && $_SERVER['QUERY_STRING'] && OoO0o0O0o() && $caiji_config['rewrite'] && (substr($_SERVER["REQUEST_URI"], 0, 2) == '/?' || (!$v_config['web_remark'] && substr($_SERVER["REQUEST_URI"], 0, 11) == '/index.php?') || preg_match('~^/' . $v_config['web_remark'] . '/\?~', $_SERVER["REQUEST_URI"]) || preg_match('~^/' . $v_config['web_remark'] . '/index.php\?~', $_SERVER["REQUEST_URI"]))) {
    $GLOBALS['geturl'] = $server_url . '/?' . $_SERVER['QUERY_STRING'];
}
if (stripos($GLOBALS['geturl'], '?') === false && stripos($GLOBALS['geturl'], '&') > -1) {
    $GLOBALS['geturl'] = preg_replace('~\&~', '?', $GLOBALS['geturl'], 1);
}
if ($ac == 'yulan') {
    $GLOBALS['geturl'] = $from_url;
}
if (SCRIPT == 'search') {
    $parse_url = parse_url($searchurl);
} else {
    $parse_url = parse_url($GLOBALS['geturl']);
}
$urlpathinfo = pathinfo($parse_url['path']);
$urldirname = $urlpathinfo['dirname'];
$urlbasename = $urlpathinfo['basename'];
$urlpath = geturlpath($parse_url);
if (stripos($_SERVER["HTTP_ACCEPT"], 'text/css') > -1) {
    $GLOBALS['urlext'] = 'css';
} else if (SCRIPT == 'css') {
    $GLOBALS['urlext'] = 'css';
} else if (SCRIPT == 'js') {
    $GLOBALS['urlext'] = 'js';
} else {
    $GLOBALS['urlext'] = strtolower(pathinfo($parse_url['path'], PATHINFO_EXTENSION));
}
$imgarr = array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'ico');
if (SCRIPT == 'img' && !in_array($GLOBALS['urlext'], $imgarr)) {
    $GLOBALS['urlext'] = 'jpg';
}
if (strpos($_SERVER['QUERY_STRING'], '..') === false && @is_file(VV_ROOT . '/' . $_SERVER['QUERY_STRING'])) {
    $getfile = false;
    if (in_array($GLOBALS['urlext'], $imgarr)) {
        header("Content-type: image/{$GLOBALS['urlext']}");
        $getfile = true;
    }
    if ($GLOBALS['urlext'] == 'js') {
        header("Content-type: text/javascript");
        $getfile = true;
    }
    if ($GLOBALS['urlext'] == 'css') {
        header("Content-type: text/css");
        $getfile = true;
    }
    if ($getfile) {
        echo @file_get_contents(VV_ROOT . '/' . $_SERVER['QUERY_STRING']);
        exit();
    }
}
define('VV_PLUS', true);
$GLOBALS['isplus'] = false;
plus_run('init');
plus_run('before_get');
if (in_array($GLOBALS['urlext'], $imgarr)) {
    if (($v_config['imgcache'] || $caiji_config['collect_close']) && OoO0o0O0o()) {
        if ($v_config['sifton']) {
            $sifturl = explode('[cutline]', $v_config['sifturl']);
            foreach ($sifturl as $k => $vo) {
                if ($vo == $GLOBALS['geturl']) {
                    header("Content-type: image/png");
                    exit();
                }
            }
        }
        $cachetime = $v_config['imgcachetime'];
        $extarr = array_merge($extarr, $imgarr);
        if (@$_GET['debug'] != 'true') {
            header("Content-type: image/{$GLOBALS['urlext']}");
        } else {
            $GLOBALS['geturl'] = str_replace('?debug=true', '', $GLOBALS['geturl']);
        }
        $iscollect = true;
        if ($caiji_config['collect_close']) {
            if (is_file($cachefile)) {
                $iscollect = false;
            } else {
                exit('not file');
            }
        }
        if ($iscollect && (!$cachetime || !is_file($cachefile) || (@filemtime($cachefile) + ($cachetime * 3600)) <= time())) {
            run_time(true);
            $str = $caiji->geturl($GLOBALS['geturl']);
            $GLOBALS['debug'][] = '使用缓存：否';
            $GLOBALS['debug'][] = '采集用时：' . run_time() . 's';
            if ($cachetime) {
                if (!empty($str)) {
                    write($cachefile, $str);
                } else if (is_file($cachefile)) {
                    $str = file_get_contents($cachefile);
                    write($cachefile, $str);
                }
            }
        } else if (is_file($cachefile)) {
            $GLOBALS['debug'][] = '使用缓存：是';
            $GLOBALS['debug'][] = '缓存路径：' . $cachefile;
            $str = file_get_contents($cachefile);
        }
        echo $str;
        if ($caiji_config['web_debug'] == "on") {
            echo "\r\n/*---调试信息 start---\r\n" . implode("\r\n", $GLOBALS['debug']) . "\r\n---调试信息 end---*/\r\n";
        }
        exit();
    } else {
        header("Content-Type: image/jpeg; charset=UTF-8");
        header("Location: {$GLOBALS['geturl']}");
        exit;
    }
}
if ($GLOBALS['urlext'] == 'css') {
    header("Content-type: text/css");
    $cachetime = $v_config['csscachetime'];
    list($cacheid,) = explode('?', $GLOBALS['geturl']);
    $cachefile = getcsscachefile($cacheid);
    $v_config['cacheon'] = $v_config['csscache'];
}
if (SCRIPT == 'js' || $GLOBALS['urlext'] == 'js') {
    header("Content-type: text/javascript");
    $cachetime = $v_config['jscachetime'];
    list($cacheid,) = explode('?', $GLOBALS['geturl']);
    $cachefile = getjscachefile($cacheid, $server_host);
    if (!$v_config['jscache']) {
        header("Location: {$GLOBALS['geturl']}");
        exit;
    }
    $v_config['cacheon'] = $v_config['jscache'];
}
if ($GLOBALS['urlext'] == 'xml') {
    header("Content-type: text/xml");
}
if ($GLOBALS['urlext'] == 'swf') {
    header("Content-type: application/x-shockwave-flash");
    header("Location: {$GLOBALS['geturl']}");
    exit;
}
if ($GLOBALS['urlext'] <> '' && !in_array($GLOBALS['urlext'], $extarr)) {
}
include(VV_DATA . '/rules_get.php');
if ($ac == 'yulan') {
    $GLOBALS['html'] = _htmlspecialchars($GLOBALS['html']);
    $GLOBALS['html'] = "	<script type=\"text/javascript\" src=\"../public/js/syntaxhighlighter/scripts/shCore.js\"></script>
	<script type=\"text/javascript\" src=\"../public/js/syntaxhighlighter/scripts/shBrushXml.js\"></script>
	<link type=\"text/css\" rel=\"stylesheet\" href=\"../public/js/syntaxhighlighter/styles/shCore.css\"/>
	<link type=\"text/css\" rel=\"stylesheet\" href=\"../public/js/syntaxhighlighter/styles/shThemeEditplus.css\"/>
	<script type=\"text/javascript\">
		SyntaxHighlighter.config.clipboardSwf = '../public/js/syntaxhighlighter/scripts/clipboard.swf';
		SyntaxHighlighter.config.tagName = 'textarea';
		SyntaxHighlighter.all();
	</script>
	<table width=\"99%\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\" class=\"tableoutline\">
	<tbody>
		<tr nowrap class=\"tb_head\">
			<td><h2>源代码查看</h2></td>
		</tr>
	</tbody>
	<tr nowrap class=\"firstalt\">
		<td><b>以下为采集规则 [{$caiji_config['name']}] 的源代码，你可以根据这个编写过滤规则:</b></td>
	</tr>
	<tr nowrap class=\"firstalt\">
		<form method=\"get\" action=\"caiji_config.php\">
		<input type=\"hidden\" name=\"ac\" value=\"{$ac}\" />
		<input type=\"hidden\" name=\"collectid\" value=\"{$collectid}\" />
		<td><input type=\"text\" name=\"url\" size=\"80\" value=\"{$from_url}\" onFocus=\"this.style.borderColor='#00CC00'\" onBlur=\"this.style.borderColor='#999999'\" > <input type=\"submit\" value=\"查看源代码\" /></td>
		</form>
	</tr>
	<tr nowrap class=\"firstalt\">
		<td><textarea style=\"height:500px\" class=\"brush: html;auto-links:false;\">{$GLOBALS['html']}</textarea></td>
	</tr>
</table>
</body>
</html>";
    $GLOBALS['html'] = ADMIN_HEAD . $GLOBALS['html'];
    exit($GLOBALS['html']);
}
if ($GLOBALS['urlext'] == 'css' || $GLOBALS['urlext'] == 'js') {
    if (substr($GLOBALS['html'], 0, 1) == '?') {
        $GLOBALS['html'] = substr($GLOBALS['html'], 1);
    }
    if ($v_config['web_debug'] == "on") {
        echo "/*---调试信息 start---\r\n" . implode("\r\n", $GLOBALS['debug']) . "\r\n---调试信息 end---*/\r\n";
    }
    echo $GLOBALS['html'];
} else if (in_array($GLOBALS['urlext'], $extarr) || stripos($GLOBALS['html'], '<head>') > -1 || stripos($GLOBALS['html'], '<html>') > -1 || stripos($GLOBALS['html'], '<body>') > -1) {
    $GLOBALS['debug'][] = '程序运行总共用时：' . round((debug_time() - RUN_TIME), 4) . 's';
    $GLOBALS['debug'][] = '内存开销：' . ((memory_get_usage() - $GLOBALS['_start_memory']) / 1024) . ' kb';
    if ($v_config['web_debug'] == "on") {
        echo echo_debug($GLOBALS['debug']);
    }
    $tplfile = VV_TMPL . '/index.html';
    if ($caiji_config['tplfile']) {
        $caiji_config['tplfile'] = str_replace('..', '', $caiji_config['tplfile']);
        $caiji_tplfile = VV_TMPL . '/' . $caiji_config['tplfile'];
        if (is_file($caiji_tplfile)) {
            $tplfile = $caiji_tplfile;
        }
    }
    $html = $GLOBALS['html'];
    if (substr($html, 0, 1) == '?') {
        $html = substr($html, 1);
    }
    if (!OoO0o0O0o()) {
        $html = preg_replace('~</body>~i', '<!-- freevslinks --><div style="display:none"><a href="http://seo.vxiaotou.com/?id=' . time() . '">http://seo.vxiaotou.com</a></div><!-- /freevslinks --></body>', $html, 1);
    }
    include($tplfile);
} else {
    echo $GLOBALS['html'];
}
if (!abcdefg()) {
    exit('error');
}
?>