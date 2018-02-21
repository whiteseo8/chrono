<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';if($id==''){$v_config['sifturl']=implode("\r\n",explode('[cutline]',$v_config['sifturl']));echo ADMIN_HEAD; ?>
<body>
<div class="right">
   <?php include "welcome.php"; ?>
  <div class="right_main">
  <form action="?id=save" method="post">
  <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<tr class="tb_head">  
		<td colspan="2">
			<h2>过滤屏蔽设置</h2>
		</td>
	</tr>
	<tr nowrap class="firstalt">
			<td width="260"><b>过滤屏蔽开关</b><br>
			<font color="#666666">过滤屏蔽</font></td>
			<td><select name="con[sifton]">
				<option value="1" <?php if($v_config['sifton'])echo "selected"; ?>>开启</option>
				<option value="0" <?php if(!$v_config['sifton'])echo "selected"; ?>>关闭</option>
			</select></td>
		</tr>
	<tr class="firstalt">
		<td width="260">
			<b>需要过滤的链接</b></font>
		</td>  
		<td>每行一条链接，当采集到此地址时自动返回404错误达到屏蔽目的<br>
		<textarea name="con[sifturl]" cols="80" style="height:120px; width:450px" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ><?php echo $v_config['sifturl'] ?></textarea>
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

<?php }elseif($id=='save'){$config=$_POST['con'];foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}$config['sifturl']=str_replace(array("\r\n","\r","\n"),'[cutline]',$config['sifturl']);$config['sifturl']=str_replace('<?','***',$config['sifturl']);$config=@array_merge($v_config,$config);if($config){arr2file(VV_DATA."/config.php",$config);}ShowMsg("恭喜你,修改成功！",'caiji_sift.php',2000);} ?>