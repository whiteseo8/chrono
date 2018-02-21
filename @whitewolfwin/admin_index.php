<?php
/*--------------------------
vivi小偷网站系统
qq:996948519
---------------------------*/
require_once('data.php');
require_once('checkAdmin.php');
echo ADMIN_HEAD;
if(@$_GET['a']=='phpinfo'){
	phpinfo();
	exit;
}
?>
<body>

<div class="right">
  <?php include "welcome.php"; ?>
  
  <div class="right_main">
    <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
      <tr class=tb_head>
        <td colspan="2" class="tbhead"><h2> 系统信息：</h2></td>
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">主机名 (IP：端口)：</td>
        <td width="75%"><?php echo $_SERVER['SERVER_NAME']?>&nbsp;&nbsp;(<?php echo $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'];?>)</td>
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">程序目录：</td>
        <td width="75%"><?php echo dirname(dirname($_SERVER['SCRIPT_FILENAME']));?></td>
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">Web服务器：</td>
        <td width="75%"><?php echo $_SERVER['SERVER_SOFTWARE']?></td>
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">PHP 运行方式：</td>
        <td width="75%"><?php echo PHP_SAPI?></td>
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">PHP版本：</td>
        <td width="75%"><?php echo PHP_VERSION?>&nbsp;&nbsp;<span style="color: #999999;">(>5.20)</span></td>
      </tr>
      
      <tr nowrap class="firstalt">
        <td width="25%">最大上传限制：</td>
        <td width="75%"><?php echo ini_get('file_uploads') ? ini_get('upload_max_filesize') : '<span style="color:red">Disabled</span>';?></td>
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">最大执行时间：</td>
        <td width="75%"><?php echo ini_get('max_execution_time')?> seconds</td>
      </tr>
	  <tr nowrap class="firstalt">
        <td width="25%">display_errors显错开关：</td>
        <td width="75%"><?php echo ini_get('display_errors') ? 'on' : 'off';  ?></td>
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">支持的采集方式：</td>
        <td width="75%">
		<?php echo function_exists('curl_init') && function_exists('curl_exec') ? '<span style="color:green">curl_init</span>' : '<span style="color:red">curl_init</span>'?> (推荐)，<?php echo (function_exists('fsockopen') || function_exists('pfsockopen') ) ? '<span style="color:green"> fsock</span>，' : '<span style="color:red"> fsockopen</span>，'?><?php echo function_exists('file_get_contents') ? '<span style="color:green"> file_get_contents</span>' : '<span style="color:red"> file_get_contents</span>'?> ( 系统会自动帮你切换 )
		</td>
      </tr>
	  <tr nowrap class="firstalt">
        <td width="25%">目录读写权限：</td>
        <td width="75%">
			/data/ [<img src="../public/img/<?php echo test_write(VV_DATA) ? 'success' : 'error';?>.png" />]、
			data.php(修改后台密码用) [<img src="../public/img/<?php echo test_write('./data.php') ? 'success' : 'error';?>.png" />]、根目录(在线升级用) [<img src="../public/img/<?php echo test_write(VV_ROOT) ? 'success' : 'error';?>.png" />]
		</td>
      </tr>
    </table>
    <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
      <tr  class=tb_head>
        <td colspan="2"><h2>产品说明：</h2></td>
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">站内新闻：</td>
    
      </tr>
	  <tr nowrap class="firstalt">
        <td width="25%">当前版本：</td>
        <td><font class="normalfont"><?php echo $version;?></font></td>
      </tr>
	  <tr nowrap class="firstalt">
        <td width="25%">检查更新：</td>
       
      </tr>
      <tr nowrap class="firstalt">
        <td width="25%">技术支持：</td>
   
      </tr>
     
    </table>
  </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>