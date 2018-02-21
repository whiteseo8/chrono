<?php
/*--------------------------
vivi小偷网站系统
qq:996948519
---------------------------*/
require_once('data.php');
require_once('checkAdmin.php');
?>

<head>
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<title>网站后台管理系统</title>
<LINK href="admin.css" type=text/css rel=stylesheet>
</head>
<frameset rows="90,*" frameborder="NO" border="0" framespacing="0" cols="*">
  <frame name="head" scrolling="NO" noresize src="top.php" >
  <frameset cols="172,*" frameborder="NO" border="0" framespacing="0" rows="*">
    <frame name="toc" scrolling="yes" noresize src="left.php">
    <frame name="content" src="admin_index.php" title="mainFrame">
  </frameset>
</frameset>
<noframes>
<body >
不支持框架!
</body>
</noframes>
</html>