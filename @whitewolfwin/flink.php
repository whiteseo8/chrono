<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';$file=VV_DATA."/flink.conf";$flink=@file_get_contents($file);if($id==''){echo ADMIN_HEAD; ?>
<body>
<div class="right">
   <?php include "welcome.php"; ?>
  <div class="right_main">
  <form action="?id=save" method="post" onSubmit="return chk();" >
  <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<tr class="tb_head">  
		<td colspan="2">
			<h2>友情链接设置</h2>
		</td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>是否自动加到首页底部</b><br>
		<font color="#666666">如不自动添加，则可以使用{flinks}进行调用</font></td>
		<td><select name="flinks_auto_insert">
			<option value="1" <?php if($v_config['flinks_auto_insert']==1||$v_config['flinks_auto_insert']=='')echo "selected"; ?>>是</option>
			<option value="2" <?php if($v_config['flinks_auto_insert']==2)echo "selected"; ?>>否</option>
		</select></td>
	</tr>
	<tr class="firstalt">
		<td width="260" align="center">
			<b>友情链接设置</b>
		</td>  
		<td>每行一个链接<br>如：&lt;a target="_blank" href='http://baidu.com' &gt;百度&lt;/a&gt;<br>
		<textarea name="flink" cols="80" style="height:120px; width:450px" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ><?php echo $flink ?></textarea>
		</td>
	</tr>
<tr class="firstalt"><td align="center" colspan="2"><input type="submit" value=" 提交 " name="submit" class="bginput">&nbsp;&nbsp;<input type="reset" value=" 重置 " name="Input" class="bginput"></td></tr>
 </table>
</form>
  </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>

<?php }elseif($id=='save'){$con=get_magic(trim($_POST['flink']));$con=str_replace('<?','***',$con);if(@preg_match("/require|include|REQUEST|eval|system|fputs/i",$con)){ShowMsg("含有非法字符,请重新设置",'-1',2000);}else{write($file,$con);extract($_POST);$config=@array_merge($v_config,array('flinks_auto_insert'=>$flinks_auto_insert));if($config){arr2file(VV_DATA."/config.php",$config);}ShowMsg("恭喜你,修改成功！",'flink.php',2000);}} ?>