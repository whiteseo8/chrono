<?php

require_once('data.php');
$v_config=require_once('../data/config.php');
require_once('../inc/common.inc.php');



if(md5($_POST['password'])==$password && $_POST['adminname']==$adminname){
	setcookie("y_Cookie", $password);
	setcookie("x_Cookie", $adminname);
    echo '<script language=javascript>window.location.href="admin.php"</script>';
    exit;
}else{
    echo '<script language=javascript>window.location.href="index.php"</script>';
}
?>





