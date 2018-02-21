<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';if($id==''){echo ADMIN_HEAD; ?>
<body>
<div class="right">
 <?php include "welcome.php"; ?>
  <div class="right_main">
<table width="98%" cellspacing="1" cellpadding="4" border="0" class="tableoutline">
	<tbody>
		<tr class="tb_head">
			<td><h2>缓存设置：</h2></td>
		</tr>
	</tbody>
</table>
<table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<form action="?id=save" method="post">
	<tbody id="config1">
		<tr nowrap class="firstalt">
			<td width="260"><b>首页缓存保存时间</b><br>
			<font color="#666666"><font color='red'>小时</font>为单位,1为1小时</font></td>
			<td><input type="text" name="con[indexcache]" size="25" maxlength="50" value="<?php echo $v_config['indexcache']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > 一般24小时内</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>内页缓存保存时间</b><br>
			<font color="#666666"><font color='red'>小时</font>为单位,1为1小时</font></td>
			<td><input type="text" name="con[othercache]" size="25" maxlength="50" value="<?php echo $v_config['othercache']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > 一般72小时内</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>图片缓存保存时间</b><br>
			<font color="#666666"><font color='red'>小时</font>为单位,1为1小时</font></td>
			<td><input type="text" name="con[imgcachetime]" size="25" maxlength="50" value="<?php echo $v_config['imgcachetime']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > 如果设置为0或不填，则不生成缓存
			</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>css缓存保存时间</b><br>
			<font color="#666666"><font color='red'>小时</font>为单位,1为1小时</font></td>
			<td><input type="text" name="con[csscachetime]" size="25" maxlength="50" value="<?php echo $v_config['csscachetime']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > 一般999小时内
			</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>js缓存保存时间</b><br>
			<font color="#666666"><font color='red'>小时</font>为单位,1为1小时</font></td>
			<td><input type="text" name="con[jscachetime]" size="25" maxlength="50" value="<?php echo $v_config['jscachetime']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > 一般999小时内
			</td>
		</tr>
		
		<tr nowrap class="firstalt">
			<td width="260"><b>缓存大小限制</b><br>
			<font color="#666666">超过设定值自动清除缓存,单位为 MB</font></td>
			<td><input type="text" name="con[delcache]" size="25" maxlength="50" value="<?php echo $v_config['delcache']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > 一般200内</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>定时检查缓存大小时间间隔</b><br>
			<font color="#666666">单位为天，间隔多少天自动扫描一次缓存大小</font><br><font color="red">扫描耗时长,建议不要设置太小值</font></td>
			<td><input type="text" name="con[delcachetime]" size="25" maxlength="50" value="<?php echo $v_config['delcachetime']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" >  一般3天内</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>自动清理缓存开关</b><br>
			<font color="#666666">开启后，超过缓存大小限制就自动清理缓存</font></td>
			<td><select name="con[deloldcache]">
				<option value="1" <?php if($v_config['deloldcache'])echo "selected"; ?>>开启</option>
				<option value="0" <?php if(!$v_config['deloldcache'])echo "selected"; ?>>关闭</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>蜘蛛记录开关</b><br>
			<font color="#666666">记录各大搜索引擎蜘蛛爬行动态</font></td>
			<td><select name="con[robotlogon]">
				<option value="1" <?php if($v_config['robotlogon'])echo "selected"; ?>>开启</option>
				<option value="0" <?php if(!$v_config['robotlogon'])echo "selected"; ?>>关闭</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>css缓存开关</b><br>
			<font color="#666666">开启css缓存，加快速度</font></td>
			<td><select name="con[csscache]">
				<option value="1" <?php if($v_config['csscache'])echo "selected"; ?>>开启</option>
				<option value="0" <?php if(!$v_config['csscache'])echo "selected"; ?>>关闭</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>js缓存开关</b><br>
			<font color="#666666">开启js缓存，加快速度，<font color="red">一般不需要开启</font></font></td>
			<td><select name="con[jscache]">
				<option value="1" <?php if($v_config['jscache'])echo "selected"; ?>>开启</option>
				<option value="0" <?php if(!$v_config['jscache'])echo "selected"; ?>>关闭</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>图片破解防盗链开关</b><br>
			<font color="red">如未防盗链不要开启</font></td>
			<td><select name="con[imgcache]">
				<option value="1" <?php if($v_config['imgcache'])echo "selected"; ?>>开启</option>
				<option value="0" <?php if(!$v_config['imgcache'])echo "selected"; ?>>关闭</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>页面缓存开关</b><br>
			<font color="#666666">开启页面缓存，节省服务器CPU资源</font></td>
			<td><select name="con[cacheon]">
				<option value="1" <?php if($v_config['cacheon'])echo "selected"; ?>>开启</option>
				<option value="0" <?php if(!$v_config['cacheon'])echo "selected"; ?>>关闭</option>
			</select></td>
		</tr>
		<tr class="firstalt"><td align="center" colspan="2"><input type="submit" value=" 提交 " name="submit" class="bginput">&nbsp;&nbsp;<input type="reset" value=" 重置 " name="Input" class="bginput"></td></tr>
	</tbody>
	</form>
</table>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>
<?php }elseif($id=='save'){$config=$_POST['con'];foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}$config=@array_merge($v_config,$config);if($config){arr2file(VV_DATA."/config.php",$config);}ShowMsg("恭喜你,修改成功！",'cache.php',2000);}