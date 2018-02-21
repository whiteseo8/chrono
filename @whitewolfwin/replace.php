<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';$file=VV_DATA."/keyword.conf";$keyword=file_get_contents($file);if($id=='wyc'||$id==''){echo ADMIN_HEAD; ?>
<body>
<div class="right">
   <?php include "welcome.php"; ?>
  <div class="right_main">
  <form action="?id=save" method="post" onSubmit="return chk();" >
  <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<tr class="tb_head">  
		<td colspan="2">
			<h2>伪原创同义词设置</h2>
		</td>
	</tr>
	<tr class="firstalt">
		<td width="260" align="center">
			<b>同义词词汇</b><br /><font color="#666666">(建议2000以内)</font>
		</td>  
		<td>每行一对同义词，以半角逗号,隔开<br>如：<br>忍耐,忍受<br>人间,人世间</font><br>
		<textarea name="keyword" cols="80" style="height:120px; width:450px" onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" ><?php echo $keyword ?></textarea>
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

<?php }elseif($id=='save'){$con=get_magic(trim($_POST['keyword']));if(@preg_match("/require|include|REQUEST|eval|system|fputs/i",$con)){ShowMsg("含有非法字符,请重新设置",'-1',2000);}else{write($file,$con);ShowMsg("恭喜你,修改成功！",'replace.php',2000);}} ?>