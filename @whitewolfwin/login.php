<?php
/*--------------------------
vivi小偷网站系统
QQ:996948519
---------------------------*/
require_once('data.php');
$v_config=require_once('../data/config.php');
require_once('../inc/common.inc.php');
if(md5($_POST['password'])==$password && $_POST['adminname']==$adminname){
	setcookie("y_Cookie", $password);
	setcookie("x_Cookie", $adminname);
	ShowMsg('成功登录，2秒钟后转向管理主页！',"admin.php",2000);
	exit;
}else{
	ShowMsg('用户名或密码错误!!!',-1,0,2000);
}
?>
