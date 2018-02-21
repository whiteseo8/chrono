<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
define('VV_PLUS',true);$ac=isset($_GET['ac'])?$_GET['ac']:'';echo ADMIN_HEAD;if($ac=='save'){$name=$_GET['name'];$name=preg_replace('~[^\w]+~','',$name);$plusconfig_file=VV_DATA.'/plus/'.$name.'/config.php';$plusconfig=require_once($plusconfig_file);$config=$_POST['plus']?$_POST['plus']:$_POST['con'];foreach($config as $k=>$vo){if(!is_array($vo)){$config[$k]=get_magic(trim($vo));}}if($plusconfig){$plusconfig=@array_merge($plusconfig,$config);}else{$plusconfig=$config;}if($plusconfig){arr2file($plusconfig_file,$plusconfig);}ShowMsg("恭喜你,保存成功！",'?',500);exit;}else if($ac=='del'){$name=$_GET['name'];$name=preg_replace('~[^\w]+~','',$name);if(is_dir(VV_DATA.'/plus/'.$name)){@removedir(VV_DATA.'/plus/'.$name);}ShowMsg("恭喜你,删除成功！",'?',500);exit;}else if($ac=='up'){if(!isset($_FILES['plusfile'])){return false;}if(!empty($_FILES['plusfile']['error'])){switch($_FILES['plusfile']['error']){case '1':$error='超过php.ini允许的大小';break;case '2':$error='超过表单允许的大小';break;case '3':$error='图片只有部分被上传';break;case '4':$error='请选择图片';break;case '6':$error='找不到临时目录';break;case '7':$error='写文件到硬盘出错';break;case '8':$error='File upload stopped by extension';break;case '999':default:$error='未知错误';}if($_FILES['plusfile']['error']!=4){ShowMsg($error,'-1',2000);}}if(!empty($_FILES['plusfile']['name'])&&!empty($_FILES['plusfile']['tmp_name'])&&$_FILES['plusfile']['error']=='0'){$file_name=$_FILES['plusfile']['name'];$tmp_name=$_FILES['plusfile']['tmp_name'];if(@is_uploaded_file($tmp_name)===false){ShowMsg($file_name."上传失败。",'-1',2000);}$filepath=VV_DATA.'/plus.zip';if(move_uploaded_file($tmp_name,$filepath)===false){ShowMsg("上传插件文件失败。",'?',1000);}require_once(VV_INC.'/pclzip.class.php');$archive=new PclZip($filepath);if($archive->extract(PCLZIP_OPT_PATH,VV_DATA.'/plus',PCLZIP_OPT_REPLACE_NEWER)==0){ShowMsg("插件解压失败，Error : ".$archive->errorInfo(true),"-1",300000);}else{@unlink($filepath);ShowMsg('恭喜你,插件上传成功！',"?",0,500);}}} ?>
<body>
<div class="right">
   <?php include "welcome.php"; ?>
  <div class="right_main">
  <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
	<tr class="tb_head">  
		<td colspan="7">
			<h2><a href="?">插件管理</a> &nbsp;&nbsp;-&nbsp;&nbsp;<a href="?ac=add" style='color:red'>上传插件</a></h2>
		</td>
	</tr>
<?php if($ac==''){$dir=VV_DATA.'/plus';$filearr=scandirs($dir);$temp=array();foreach($filearr as $k=>$vo){if($vo<>'.'&&$vo<>'..'){if(is_dir("$dir/$vo")){$plusfile=$dir.'/'.$vo.'/'.$vo.'.class.php';if(!is_file($plusfile)){continue;}require_once($plusfile);$plusclass=new $vo;$plusinfo=$plusclass->info;$temp[]=array_merge($plusinfo,array('file'=>$vo));}}}if(!OoO0o0O0o()){$temp=array();} ?>
	<tr nowrap class="firstalt">
		<td width="50" align="center"><b>ID</b></td>
		<td width="200" align="center"><b>插件名称</b></td>
		<td width="300" align="center"><b>插件说明</b></td>
		<td width="100" align="center"><b>作者</b></td>
		<td width="130" align="center"><b>版本</b></td>
		<td width="150" align="center"><b>操作</b></td>
		<td>&nbsp;</td>
	</tr>
<?php if($temp){foreach($temp as $k=>$vo){ ?>
	<tr nowrap class="firstalt">
		<td align="center"><?php echo $k ?></td>
		<td style="padding-left:20px"><?php echo $vo['name'] ?></td>
		<td style="padding-left:20px"><?php echo $vo['info'] ?></td>
		<td align="center"><?php echo $vo['author'] ?></td>
		<td align="center"><?php echo $vo['version'] ?></td>
		<td align="center"><?php if(@is_file(VV_DATA.'/plus/'.$vo['file'].'/run.php')){ ?><a href="?ac=run&name=<?php echo $vo['file'] ?>">运行</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?><?php if(@is_file(VV_DATA.'/plus/'.$vo['file'].'/config.php')){ ?><a href="?ac=xiugai&name=<?php echo $vo['file'] ?>">配置</a><?php }else{ ?><font color="red">无配</font><?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?ac=del&name=<?php echo $vo['file'] ?>" onClick="return confirm('确定删除?')">删除</a></td>
		<td>&nbsp;</td>
	</tr>
<?php }}else{ ?>
	<tr nowrap class="firstalt">
		<td colspan="7" align="center">没有找到插件！</td>
	</tr>
<?php }}else if($ac=='xiugai'){$name=$_GET['name'];$name=preg_replace('~[^\w]+~','',$name);if(!is_dir(VV_DATA.'/plus/'.$name)){ShowMsg("插件不存在！！",'?',2000);exit;}$plusconfig_file=VV_DATA.'/plus/'.$name.'/config.php';$plusclass_file=VV_DATA.'/plus/'.$name.'/'.$name.'.class.php';if(!is_file($plusconfig_file)){ShowMsg("插件配置不存在！！",'?',2000);exit;}if(!is_file($plusclass_file)){ShowMsg("插件不存在2！！",'?',2000);exit;}require_once($plusclass_file);$plusclass=new $name;$plusconfig=require_once($plusconfig_file); ?>
	<tr nowrap class="firstalt">
		<td colspan="2">【<?php echo $plusclass->info['name']; ?>】插件配置</td>
	</tr>
<form action="?ac=save&name=<?php echo $name; ?>" method="post">
<?php @include(VV_DATA.'/plus/'.$name.'/'.$name.'.form.html'); ?>
	<tr class="firstalt">
		<td>&nbsp;</td>
		<td colspan="2">
			<input type="submit" value=" 保存 " name="submit" class="bginput">&nbsp;&nbsp;<input type="button" onclick="history.go(-1);" value=" 返回 " name="Input" class="bginput"></td>
		</tr>
</form>
<?php }else if($ac=='add'){ ?>
<form method="post" action="?ac=up" enctype="multipart/form-data">
	<tr class="firstalt">
		<td width="180"><b>上传插件</b><br>
		<font color="#666666">如存在同名插件将会被覆盖</font></td>
		<td><input name="plusfile" type="file"></td>
	</tr>
	<tr class="firstalt">
		<td >&nbsp;</td>
		<td>
			<input class="bginput" type="submit" name="submit" onclick='this.value="正在上传..."' value=" 上传 ">
		</td>
	</tr>
</form>
<?php }else if($ac=='run'){$name=$_GET['name'];$name=preg_replace('~[^\w]+~','',$name);$plusrun_file=VV_DATA.'/plus/'.$name.'/run.php';include($plusrun_file);} ?>
 </table>
</form>
  </div>
</div>
<?php include "footer.php"; ?>
</body>
</htm>