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
			<h2>URL�������</h2>
		</td>
	</tr>
	<tr nowrap class="firstalt">
		<td colspan="2">
			<font color="blue" style="font-size:18px;">ע��α��̬�Ŀ������޸Ľڵ�ĸ߼�����������</font>
		</td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>α��̬��ʶ��</b><img src="../public/img/vip.gif" style="cursor: pointer;vertical-align: middle;" title="vip����" width="19" height="18" /><br>
		<font color="#666666">α��̬���ַǰ���ʶ<br>�磺http://baidu.com/<font color="red">html</font>/xxx.php<br><font color="red">�޸ĺ�ǵ��޸�α��̬��������ı�ʶ��<br>ע�⣺�������Ļ�����Ҫ�Ѻ�̨�ļ���������Ϊ@��ͷ���磺@admin</font></font></td>
		<td><input name="con[web_remark]" type="text" value="<?php echo $sign; ?>" size="15" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" >&nbsp;&nbsp;��ĸ�����֣�<font color="red">α��̬������ο���̳�ö��� (<a href="http://www.vxiaotou.com/thread-894-1-1.html" target="_blank">��˷���</a>) </font></td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>URL����ת��</b><br>
		<font color="#666666">�����ı�url��ַ��������seo</font></td>
		<td><select name="con[web_urlencode]" >
			<option value="1" <?php if($v_config['web_urlencode'])echo " selected"; ?>>����</option>
			<option value="0" <?php if(!$v_config['web_urlencode'])echo " selected"; ?>>�ر�</option>
		</select></td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>URL���ܷ���</b><br>
		<font color="#666666">��ͬ�ķ�����ͬ��Ч��</font></td>
		<td><select name="con[web_urlencode_type]" >
			<option value="base64" <?php if($v_config['web_urlencode_type']=='base64'||empty($v_config['web_urlencode_type']))echo " selected"; ?>>base64</option>
			<option value="jiandan" <?php if($v_config['web_urlencode_type']=='jiandan')echo " selected"; ?>>��ת��</option>
			<option value="str_rot13" <?php if($v_config['web_urlencode_type']=='str_rot13')echo " selected"; ?>>ת����ĸ</option>
		</select></td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>������Կ</b><br>
		<font color="#666666">����base64������Ч�����ĺ����������</font></td>
		<td><input type="text" name="con[web_urlencode_key]" size="15" value="<?php echo $v_config['web_urlencode_key']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ></td>
	</tr>
	<tr nowrap class="firstalt">
		<td width="260"><b>URL��׺</b><br>
		<font color="#666666">Ĭ��Ϊ html�����ô���</font></td>
		<td><input type="text" name="con[web_urlencode_suffix]" size="15" value="<?php echo $suffix; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ></td>
	</tr>
	<tr class="firstalt"><td align="center" colspan="2"><input type="submit" value=" �ύ " name="submit" class="bginput">&nbsp;&nbsp;<input type="reset" value=" ���� " name="Input" class="bginput"></td></tr>
 </table>
</form>
  </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>

<?php }elseif($id=='save'){$config=$_POST['con'];foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}$link_config=$_POST['link_config'];$link_config=str_replace(array("\r\n","\r","\n"),'|||',$link_config);$config=@array_merge($v_config,$config);if($config){arr2file(VV_DATA."/config.php",$config);}write($linkwordfile,$link_config);ShowMsg("��ϲ��,�޸ĳɹ���",'?',2000);} ?>