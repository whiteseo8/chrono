<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
$id=isset($_GET['id'])?$_GET['id']:'';if($id=='edit'||$id==''){echo ADMIN_HEAD; ?>
<script>
function chk(){
	if(form.adminname.value==''){
		alert('管理员帐号为空');
		return false;
	}
	if(form.password.value=='' || form.password.value!=form.password1.value){
		alert('密码为空或再次输入不一致');
		return false;
	}
}
</script>
<body> 
<div class="right">
  <? include "welcome.php"; ?>
  <div class="right_main">
  
  
  <form action="?id=save"  method="post" name="form" onsubmit="return chk();">
    <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline"> 

        <tr nowrap  class="tb_head">
          <td colspan="2"><h2>修改密码：</h2></td>
        </tr>
        <tr nowrap class="firstalt">
          <td width="260"><b>用户名</b><br><font color="#666666">不修改，请保留</font></td>
          <td><input  type="text" name="adminname" size="33" value="<?php echo $adminname; ?>"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" >
          </td>
        </tr>
		<tr nowrap class="firstalt">
          <td width="260"><b>新密码</b><br><font color="#666666">输入新的密码</font></td>
          <td><input  type="password" name="password" size="37"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" >
          </td>
        </tr>
        <tr nowrap class="firstalt">
          <td width="260"><b>重复新密码</b><br><font color="#666666">重复输入新的密码</font></td>
          <td><input  type="password" name="password1" size="37"onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'" >
          </td>
        </tr>
        <tr class="firstalt"><td align="center" colspan="2"><input type="submit" value=" 提交 " name="submit" class="bginput">&nbsp;&nbsp;<input type="reset" value=" 重置 " name="Input" class="bginput"></td></tr>
     </form>
    </table>  
  
 
  </div>
</div>
</body>
</html>

<?php }elseif($id=='save'){$_POST['adminname']=_htmlspecialchars($_POST['adminname']);$con='<?php'."\r\n".'$adminname='.'"'.trim($_POST['adminname']).'"'.";\r\n".'$password='.'"'.md5($_POST['password']).'"'.";\r\n?>";if(@preg_match("/require|include|REQUEST|eval|system|fputs/i",$con)){ShowMsg("含有非法字符,请重新设置",'-1',2000);}else{write("data.php",$con);ShowMsg("账号修改成功,请重新登录！",'index.php',2000);}} ?>