<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';if($id==''){echo ADMIN_HEAD;$sign=isset($v_config['web_remark'])?$v_config['web_remark']:'html';$suffix=$v_config['web_urlencode_suffix']?$v_config['web_urlencode_suffix']:'html'; ?>
<body>
<div class="right">
   <?php include "welcome.php"; ?>
  <div class="right_main">
  <form action="?id=save" method="post">
  <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<tr class="tb_head">  
		<td colspan="2">
			<h2>URL规则管理</h2>
		</td>
	</tr>
	<tr nowrap class="firstalt">
		<td colspan="2">
			<font color="blue" style="font-size:18px;">注：伪静态的开关在修改节点的高级功能里启用</font>
		</td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>伪静态标识符</b><img src="../public/img/vip.gif" style="cursor: pointer;vertical-align: middle;" title="vip功能" width="19" height="18" /><br>
		<font color="#666666">伪静态后地址前面标识<br>如：http://baidu.com/<font color="red">html</font>/xxx.php<br><font color="red">修改后记得修改伪静态规则里面的标识符<br>注意：如果不填的话，需要把后台文件夹重命名为@开头，如：@admin</font></font></td>
		<td><input name="con[web_remark]" type="text" value="<?php echo $sign; ?>" size="15" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" >&nbsp;&nbsp;字母或数字，<font color="red">伪静态规则请参考论坛置顶帖 (<a href="http://www.vxiaotou.com/thread-894-1-1.html" target="_blank">点此访问</a>) </font></td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>URL加密转换</b><br>
		<font color="#666666">开启改变url地址，有利于seo</font></td>
		<td><select name="con[web_urlencode]" >
			<option value="1" <?php if($v_config['web_urlencode'])echo " selected"; ?>>开启</option>
			<option value="0" <?php if(!$v_config['web_urlencode'])echo " selected"; ?>>关闭</option>
		</select></td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>URL加密方法</b><br>
		<font color="#666666">不同的方法不同的效果</font></td>
		<td><select name="con[web_urlencode_type]" >
			<option value="base64" <?php if($v_config['web_urlencode_type']=='base64'||empty($v_config['web_urlencode_type']))echo " selected"; ?>>base64</option>
			<option value="jiandan" <?php if($v_config['web_urlencode_type']=='jiandan')echo " selected"; ?>>简单转换</option>
			<option value="str_rot13" <?php if($v_config['web_urlencode_type']=='str_rot13')echo " selected"; ?>>转换字母</option>
		</select></td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>加密密钥</b><br>
		<font color="#666666">仅对base64方法有效，更改后需清除缓存</font></td>
		<td><input type="text" name="con[web_urlencode_key]" size="15" value="<?php echo $v_config['web_urlencode_key']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ></td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>URL后缀</b><br>
		<font color="#666666">默认为 html，不用带点</font></td>
		<td><input type="text" name="con[web_urlencode_suffix]" size="15" value="<?php echo $suffix; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ></td>
	</tr>
	<tr class="firstalt"><td align="center" colspan="2"><input type="submit" value=" 提交 " name="submit" class="bginput">&nbsp;&nbsp;<input type="reset" value=" 重置 " name="Input" class="bginput"></td></tr>
 </table>
</form>
  </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>

<?php }elseif($id=='save'){$config=$_POST['con'];foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}$link_config=$_POST['link_config'];$link_config=str_replace(array("\r\n","\r","\n"),'|||',$link_config);$config=@array_merge($v_config,$config);if($config){arr2file(VV_DATA."/config.php",$config);}write($linkwordfile,$link_config);ShowMsg("恭喜你,修改成功！",'?',2000);} ?>