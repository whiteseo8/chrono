<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';if($id==''){$v_config['ban_zhizhu_list']=explode(',',$v_config['ban_zhizhu_list']);echo ADMIN_HEAD; ?>
<body>
<div class="right">
   <?php include "welcome.php"; ?>
  <div class="right_main">
  <form action="?id=save" method="post">
  <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<tr class="tb_head">  
		<td colspan="2">
			<h2>֩����������</h2>
		</td>
	</tr>
	<tr nowrap class="firstalt">
			<td width="200"><b>֩�����ο���</b><br>
			<font color="#666666">֩������</font></td>
			<td><select name="con[ban_zhizhu_on]">
				<option value="1" <?php if($v_config['ban_zhizhu_on'])echo "selected"; ?>>����</option>
				<option value="0" <?php if(!$v_config['ban_zhizhu_on'])echo "selected"; ?>>�ر�</option>
			</select></td>
		</tr>
	<tr class="firstalt">
		<td>
			<b>֩���б�</b><br>
			<font color="#666666">��Ҫ���ε�֩���</font>
		</td>  
		<td>
			<label><input type="checkbox" name="ban[]" value="baiduspider" <?php if(in_array('baiduspider',$v_config['ban_zhizhu_list']))echo "checked"; ?> />�ٶ�֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="googlebot" <?php if(in_array('googlebot',$v_config['ban_zhizhu_list']))echo "checked"; ?> />�ȸ�֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="360spider" <?php if(in_array('360spider',$v_config['ban_zhizhu_list']))echo "checked"; ?> />360֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="Yisouspider" <?php if(in_array('Yisouspider',$v_config['ban_zhizhu_list']))echo "checked"; ?> />��������</label><br>
			<label><input type="checkbox" name="ban[]" value="soso" <?php if(in_array('soso',$v_config['ban_zhizhu_list']))echo "checked"; ?> />soso֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="sogou" <?php if(in_array('sogou',$v_config['ban_zhizhu_list']))echo "checked"; ?> />sogou֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="yahoo" <?php if(in_array('yahoo',$v_config['ban_zhizhu_list']))echo "checked"; ?> />yahoo֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="msn" <?php if(in_array('msn',$v_config['ban_zhizhu_list']))echo "checked"; ?> />msn֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="sohu" <?php if(in_array('sohu',$v_config['ban_zhizhu_list']))echo "checked"; ?> />Sohu֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="yodaoBot" <?php if(in_array('yodaoBot',$v_config['ban_zhizhu_list']))echo "checked"; ?> />yodao֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="iaskspider" <?php if(in_array('iaskspider',$v_config['ban_zhizhu_list']))echo "checked"; ?> />���˰���</label><br>
			<label><input type="checkbox" name="ban[]" value="ia_archiver" <?php if(in_array('ia_archiver',$v_config['ban_zhizhu_list']))echo "checked"; ?> />Alexa֩��</label><br>
			<label><input type="checkbox" name="ban[]" value="other" <?php if(in_array('other',$v_config['ban_zhizhu_list']))echo "checked"; ?> />����֩��</label><br>
		</td>
	</tr>
<script type="text/javascript">
document.write(submit);
</script>
 </table>
</form>
  </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>

<?php }elseif($id=='save'){$config=$_POST['con'];foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}$config['ban_zhizhu_list']=@implode(',',$_POST['ban']);$config=@array_merge($v_config,$config);if($config){arr2file(VV_DATA."/config.php",$config);}ShowMsg("��ϲ��,�޸ĳɹ���",'?',1000);} ?>