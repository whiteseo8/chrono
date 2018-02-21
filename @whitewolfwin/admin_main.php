<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';if($id=='man'||$id==''){echo ADMIN_HEAD; ?>
<body>
<div class="right">
 <?php include "welcome.php"; ?>
  <div class="right_main">
<table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<form action="?id=save" method="post">
	<tbody id="config1">
		<tr nowrap class="tb_head">
			<td colspan="2">
			<h2>网站信息：</h2>
			</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>网站名称</b><br></td>
			<td><input type="text" name="con[web_name]" size="30" value="<?php echo $v_config['web_name']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ></td>
		</tr>

		<tr nowrap class="firstalt">
			<td width="260"><b>首页标题</b><br>
			<font color="#666666">用在首页，有利于优化</font></td>
			<td><input type="text" name="con[web_seo_name]" size="30" value="<?php echo $v_config['web_seo_name']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > 如设置为空则使用目标站的</td>
		</tr>

		<tr nowrap class="firstalt">
			<td width="260"><b>网站地址</b><br>
			<font color="#666666">你的网址,以<font color="red">http://</font>开头,<font color="red">斜杠"/"</font>结尾</font></td>
			<td><input type="text" name="con[web_url]" id="web_url" size="30" value="<?php echo $v_config['web_url']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="checkurl(this.id);this.style.borderColor='#dcdcdc'" > <a id="web_url_msg"></a></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>首页关键字</b><br>
			<font color="#666666">首页关键字keywords</font></td>
			<td><input name="con[web_keywords]" type="text" value="<?php echo $v_config['web_keywords']; ?>" size="55" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > 如设置为空则使用目标站的</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>首页网站描述</b><br>
			<font color="#666666">首页描述</font></td>
			<td><textarea name="con[web_description]" cols="80" style="height: 70px; width: 350px" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ><?php echo $v_config['web_description']; ?></textarea> 如设置为空则使用目标站的</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>错误跳转url地址</b><br>
			<font color="#666666">采集到错误页后跳转到的url地址<br>如：<font color="red">http://x.com/404.html</font></font></td>
			<td><input type="text" name="con[web_404_url]" id="web_404_url" size="60" value="<?php echo $v_config['web_404_url']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="checkurl(this.id);this.style.borderColor='#dcdcdc'" > </td>
		</tr>
		<tr class="firstalt">
			<td width="260" valign="top"><b>统计代码</b><br>
			<font color="#666666">流量统计代码<br></font></td>
			<td><textarea name="con[web_tongji]" cols="80" style="height: 70px; width: 350px" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ><?php echo $v_config['web_tongji']; ?></textarea></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>调试模式</b><br>
			<font color="#666666">开启调试模式后，将输出调试信息，便于发现解决错误</font></td>
			<td><select name="con[web_debug]" >
				<option value="off" <?php if($v_config['web_debug']=="off")echo " selected"; ?>>关闭</option>
				<option value="on" <?php if($v_config['web_debug']=="on")echo " selected"; ?>>开启</option>
			</select></td>
		</tr>
		<tr class="firstalt"><td align="center" colspan="2"><input type="submit" value=" 提交 " name="submit" class="bginput">&nbsp;&nbsp;<input type="reset" value=" 重置 " name="Input" class="bginput"></td></tr>
	</tbody>
	</form>
</table>
</div>
</div>
<?php include "footer.php"; ?>
<script type="text/javascript">
function msg(id,str){
	if( id=='error') return '<span class="error_msg">'+str+'</span>';
	if( id=='success') return '<span class="success_msg">'+str+'</span>';
}
function checkurl(id){
	var url=$('#'+id).val();
	if(url=='' || url.substr(0,7)!='http://' || url.substr(-1,1)!='/' ){
		$('#'+id+'_msg').html(msg('error','网址格式不正确！'));
	}else{
		$('#'+id+'_msg').html(msg('success','填写正确'));
	}
}
</script>
</body>
</html>
<?php }

elseif($id=='save'){$config=$_POST['con'];foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}$config['web_tongji']=get_magic($config['web_tongji']);if(substr($config['web_url'],-1)!='/')ShowMsg("网站地址格式不正确",'-1',3000);if(!$v_config)$v_config=$config;$config=@array_merge($v_config,$config);if($config){arr2file(VV_DATA."/config.php",$config);}ShowMsg("恭喜你,修改成功！",'admin_main.php?id=man',2000);}
?>