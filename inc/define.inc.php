<?php
$header="Content-type: text/html; charset=gbk";
header($header);
define('VV_INC', str_replace("\\", '/', dirname(__FILE__)));
define('VV_ROOT', str_replace("\\", '/', substr(VV_INC, 0, -4)));
?>