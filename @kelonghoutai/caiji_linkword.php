<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';if($id==''){$link_config=@file_get_contents($linkwordfile);$link_config=@implode("\r\n",@explode('|||',$link_config));echo ADMIN_HEAD; ?>
<body>
<div class="right">
   <?php include "welcome.php"; ?>
  <div class="right_main">
  <form action="?id=save" method="post">
  <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<tr class="tb_head">  
		<td colspan="2">
			<h2>�ؼ�������</h2>
		</td>
	</tr>
	<tr nowrap class="firstalt">
			<td width="260"><b>�ؼ�����������</b> <br>
			<font color="#666666">�Ƿ����ؼ�������������ҳ</font></td>
			<td><select name="con[linkword_on]" >
				<option value="1" <?php if($v_config['linkword_on'])echo " selected"; ?>>����</option>
				<option value="0" <?php if(!$v_config['linkword_on'])echo " selected"; ?>>�ر�</option>
			</select></td>
		</tr>
	<tr class="firstalt">
		<td width="260">
			<b>���õ�����</b></font>
		</td>  
		<td>ÿ��һ���ؼ��ʺ����ӣ��á�,������<br> �磺<br> �ٶ�,http://baidu.com<br>��Ѷ,http://qq.com<br>
		<textarea name="link_config" cols="80" style="height:120px; width:450px" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ><?php echo $link_config ?></textarea>
		</td>
	</tr>
<tr class="firstalt"><td align="center" colspan="2"><input type="submit" value=" �ύ " name="submit" class="bginput">&nbsp;&nbsp;<input type="reset" value=" ���� " name="Input" class="bginput"></td></tr>
 </table>
</form>
  </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>

<?php }elseif($id=='save'){$config=$_POST['con'];foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}$link_config=$_POST['link_config'];$link_config=str_replace(array("\r\n","\r","\n"),'|||',$link_config);$config=@array_merge($v_config,$config);if($config){arr2file(VV_DATA."/config.php",$config);}write($linkwordfile,$link_config);ShowMsg("��ϲ��,�޸ĳɹ���",'caiji_linkword.php',2000);} ?>