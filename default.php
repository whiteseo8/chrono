<?php
define('l_ok','1');
$v_config=require("data/config.php");
header('content-type:text/html;charset=gbk');
?>
<!DOCTYPE>
<html>
	<head>
		<title><?php echo $v_config['web_seo_name'];?></title>
		<meta charset="gbk">
		<meta name="keywords" content="<?php echo $v_config['web_keywords'];?>"/>
		<meta name="description" content="<?php	echo $v_config['web_description'];?>"/>
		<style>
		body{margin:0px;}
		</style>

	</head>
	<body>
                <script type="text/javascript" src="/selectivizr.js"></script>
                <script type="text/javascript" src="/tj.js"></script>
		<h2><?php echo $v_config['web_seo_name'];?></h2>
	</body>
</html>



