<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';if($id==''){echo ADMIN_HEAD; ?>
<body>
<div class="right">
 <?php include "welcome.php"; ?>
  <div class="right_main">
<table width="98%" cellspacing="1" cellpadding="4" border="0" class="tableoutline">
	<tbody>
		<tr class="tb_head">
			<td><h2>�������ã�</h2></td>
		</tr>
	</tbody>
</table>
<table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<form action="?id=save" method="post">
	<tbody id="config1">
		<tr nowrap class="firstalt">
			<td width="260"><b>��ҳ���汣��ʱ��</b><br>
			<font color="#666666"><font color='red'>Сʱ</font>Ϊ��λ,1Ϊ1Сʱ</font></td>
			<td><input type="text" name="con[indexcache]" size="25" maxlength="50" value="<?php echo $v_config['indexcache']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > һ��24Сʱ��</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>��ҳ���汣��ʱ��</b><br>
			<font color="#666666"><font color='red'>Сʱ</font>Ϊ��λ,1Ϊ1Сʱ</font></td>
			<td><input type="text" name="con[othercache]" size="25" maxlength="50" value="<?php echo $v_config['othercache']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > һ��72Сʱ��</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>ͼƬ���汣��ʱ��</b><br>
			<font color="#666666"><font color='red'>Сʱ</font>Ϊ��λ,1Ϊ1Сʱ</font></td>
			<td><input type="text" name="con[imgcachetime]" size="25" maxlength="50" value="<?php echo $v_config['imgcachetime']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > �������Ϊ0��������ɻ���
			</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>css���汣��ʱ��</b><br>
			<font color="#666666"><font color='red'>Сʱ</font>Ϊ��λ,1Ϊ1Сʱ</font></td>
			<td><input type="text" name="con[csscachetime]" size="25" maxlength="50" value="<?php echo $v_config['csscachetime']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > һ��999Сʱ��
			</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>js���汣��ʱ��</b><br>
			<font color="#666666"><font color='red'>Сʱ</font>Ϊ��λ,1Ϊ1Сʱ</font></td>
			<td><input type="text" name="con[jscachetime]" size="25" maxlength="50" value="<?php echo $v_config['jscachetime']; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > һ��999Сʱ��
			</td>
		</tr>
		
		<tr nowrap class="firstalt">
			<td width="260"><b>�����С����</b><br>
			<font color="#666666">�����趨ֵ�Զ��������,��λΪ MB</font></td>
			<td><input type="text" name="con[delcache]" size="25" maxlength="50" value="<?php echo $v_config['delcache']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" > һ��200��</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>��ʱ��黺���Сʱ����</b><br>
			<font color="#666666">��λΪ�죬����������Զ�ɨ��һ�λ����С</font><br><font color="red">ɨ���ʱ��,���鲻Ҫ����̫Сֵ</font></td>
			<td><input type="text" name="con[delcachetime]" size="25" maxlength="50" value="<?php echo $v_config['delcachetime']; ?>" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" >  һ��3����</td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>�Զ������濪��</b><br>
			<font color="#666666">�����󣬳��������С���ƾ��Զ�������</font></td>
			<td><select name="con[deloldcache]">
				<option value="1" <?php if($v_config['deloldcache'])echo "selected"; ?>>����</option>
				<option value="0" <?php if(!$v_config['deloldcache'])echo "selected"; ?>>�ر�</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>֩���¼����</b><br>
			<font color="#666666">��¼������������֩�����ж�̬</font></td>
			<td><select name="con[robotlogon]">
				<option value="1" <?php if($v_config['robotlogon'])echo "selected"; ?>>����</option>
				<option value="0" <?php if(!$v_config['robotlogon'])echo "selected"; ?>>�ر�</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>css���濪��</b><br>
			<font color="#666666">����css���棬�ӿ��ٶ�</font></td>
			<td><select name="con[csscache]">
				<option value="1" <?php if($v_config['csscache'])echo "selected"; ?>>����</option>
				<option value="0" <?php if(!$v_config['csscache'])echo "selected"; ?>>�ر�</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>js���濪��</b><br>
			<font color="#666666">����js���棬�ӿ��ٶȣ�<font color="red">һ�㲻��Ҫ����</font></font></td>
			<td><select name="con[jscache]">
				<option value="1" <?php if($v_config['jscache'])echo "selected"; ?>>����</option>
				<option value="0" <?php if(!$v_config['jscache'])echo "selected"; ?>>�ر�</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>ͼƬ�ƽ����������</b><br>
			<font color="red">��δ��������Ҫ����</font></td>
			<td><select name="con[imgcache]">
				<option value="1" <?php if($v_config['imgcache'])echo "selected"; ?>>����</option>
				<option value="0" <?php if(!$v_config['imgcache'])echo "selected"; ?>>�ر�</option>
			</select></td>
		</tr>
		<tr nowrap class="firstalt">
			<td width="260"><b>ҳ�滺�濪��</b><br>
			<font color="#666666">����ҳ�滺�棬��ʡ������CPU��Դ</font></td>
			<td><select name="con[cacheon]">
				<option value="1" <?php if($v_config['cacheon'])echo "selected"; ?>>����</option>
				<option value="0" <?php if(!$v_config['cacheon'])echo "selected"; ?>>�ر�</option>
			</select></td>
		</tr>
		<tr class="firstalt"><td align="center" colspan="2"><input type="submit" value=" �ύ " name="submit" class="bginput">&nbsp;&nbsp;<input type="reset" value=" ���� " name="Input" class="bginput"></td></tr>
	</tbody>
	</form>
</table>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>
<?php }elseif($id=='save'){$config=$_POST['con'];foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}$config=@array_merge($v_config,$config);if($config){arr2file(VV_DATA."/config.php",$config);}ShowMsg("��ϲ��,�޸ĳɹ���",'cache.php',2000);}