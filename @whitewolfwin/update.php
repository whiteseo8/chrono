<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
header("Cache-Control:no-stroe,no-cache,must-revalidate,post-check=0,pre-check=0");echo ADMIN_HEAD; ?>
<body>
<?php 
$vv=$_GET['t'];switch($vv){case "updatenow":updatenow();break;case "update":update($upname);break;}
?>