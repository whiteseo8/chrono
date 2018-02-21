<?php
/*--------------------------
vivi小偷网站系统
QQ:996948519
---------------------------*/
require_once('../inc/common.inc.php');
if($_COOKIE['x_Cookie']!=$adminname || $_COOKIE['y_Cookie']!=$password){
	ShowMsg('登录超时,请重新登录！',"index.php",2000);
}
?>