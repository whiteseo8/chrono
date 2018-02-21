<?php require_once("data.php");
$v_config = require_once("../data/config.php");
require_once("checkAdmin.php");
$ac = isset($_GET['ac'])?$_GET['ac']:'';
if($ac == 'save'){
     $array = array();
     foreach($_POST['marks']as $k => $vo){
         $array[$k]['sm'] = trim($_POST['sm'][$k]);
         $array[$k]['mark'] = trim($_POST['marks'][$k]);
         $array[$k]['body'] = get_magic(trim($_POST['bodys'][$k]));
         }
     $data = serialize($array);
     write($adsfile, $data);
     ShowMsg("恭喜你,修改成功！", '?', 2000);
     exit;
    }
if($ac == 'insert'){
     $sm = trim($_POST['sm']);
     $mark = trim($_POST['mark']);
     $body = get_magic(trim($_POST['body']));
     if('' == $mark){
         ShowMsg("请填写广告标识", '-1', 3000);
         exit;
         }
     if($config_ads){
         foreach($config_ads as $k => $vo){
             if($vo['mark'] == $mark){
                 ShowMsg("广告标识已存在，请另起一个", '-1', 3000);
                 exit;
                 }
             }
         }
     $config_ads[] = array('mark' => $mark, 'body' => $body, 'sm' => $sm);
     $data = serialize($config_ads);
     write($adsfile, $data);
     ShowMsg("恭喜你,添加成功！", '?', 2000);
     exit;
    }
if($ac == 'del'){
     $mark = trim($_GET['mark']);
     foreach($config_ads as $k => $vo){
         if($vo['mark'] == $mark){
             unset($config_ads[$k]);
             }
         }
     $config_ads = array_values($config_ads);
     $data = serialize($config_ads);
     write($adsfile, $data);
     ShowMsg("恭喜你,删除成功！", '?', 2000);
     exit;
    }
echo ADMIN_HEAD;
?>


<style type="text/css">
.tips {
  border: 1px #fff1b9 solid;
  background: #fffef1;
  line-height: 20px;
  padding: 9px 16px;
  color: #555;
}
</style>
<body>
 <?php if($ac == 'preview'){
     $mark = trim($_GET['mark']);
     $body = get_ads_body($mark);
     echo $body;
     exit;
    }
?>
<div class="right">
<?php include "welcome.php";
?>
  <div class="right_main">
    <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
<?php if($ac == ''){
     ?>
	<form action="?ac=save" method="post">
      <tbody>
		<tr nowrap  class="tb_head">
          <td colspan="6"><h2><font color="red">广告代码为HTML格式</font> - &nbsp;<a href="?ac=add"><font color="blue">添加广告</font></a></h2></td>
        </tr>
		<tr align='center' class="firstalt">
			<td width="80">id</td>
			<td width="120">广告标识</td>
			<td width="200">替换标签</td>
			<td width="150">广告说明</td>
			<td>广告代码（html代码）</td>
			<td width="90">操作</td>
		</tr>
<?php if($config_ads){
         krsort($config_ads);
         foreach($config_ads as $k => $vo){
             $readonly = '';
             if($vo['mark'] == 'top' || $vo['mark'] == 'bottom'){
                 $readonly = 'readonly';
                 }
             ?>
		<tr nowrap class="firstalt">
          <td align="center"><?php echo $k + 1;
             ?></td>
		  <td><input name="marks[]" type="text" value="<?php echo $vo['mark'];
             ?>" maxlength="50" style="width:90px" <?php echo $readonly;
             ?>></td>  
		  <td><p class="tips" style="font-size:11px">{ad.<?php echo $vo['mark'];
             ?>}</p></td>
		  <td><input name="sm[]" type="text" value="<?php echo $vo['sm'];
             ?>" style="width:130px"></td>  
		  <td><textarea name="bodys[]" rows="3" style="width:98%"><?php echo _htmlspecialchars($vo['body']);
             ?></textarea></td>   
		  <td align="center"><a href="?ac=preview&mark=<?php echo $vo['mark'];
             ?>" target="_blank">预览</a>&nbsp;&nbsp;<?php if(!$readonly){
                 ?><a href="?ac=del&mark=<?php echo $vo['mark'];
                 ?>" onClick="return confirm('确定要删除吗?')">删除</a><?php }else{
                 echo '<font color="red">内置</font>';
                 }
             ?></td>
        </tr>
<?php }
         }else{
         ?>
	<tr nowrap class="firstalt" align='center'>
		<td colspan="6">没有广告</td>
	</tr>
<?php }
     ?>
		</tbody>
		<tr class="firstalt">
          <td colspan="6" align="center">
            <input class="bginput" type="submit" name="submit" value=" 保存 " >
            <input class="bginput" type="button" onclick="history.back();" name="Input" value=" 返回 " >
          </td>
        </tr>
      </form>
    </table>
<?php }elseif($ac == 'add'){
     ?>
<table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
<form action="?ac=insert" method="post">
		<tr nowrap  class="tb_head">
          <td colspan="2"><h2>添加广告 - <font color="red">广告代码为HTML格式</font></a></h2></td>
        </tr>
		<tr class="firstalt">
		  <td width="120" align="right">广告标识：</td>
		  <td><input name="mark" type="text" class="input" maxlength="50" value="" style="width:200px"> * 注：禁止使用中文</td>
		</tr>
		<tr class="firstalt">
		  <td width="120" align="right">广告说明：</td>
		  <td><input name="sm" type="text" class="input" maxlength="50" value="" style="width:200px"></td>
		</tr>
		<tr class="firstalt">
		  <td align="right">广告代码：</td>
		  <td><textarea name="body" cols="80" style="height:100px; width:400px"></textarea> * 注：广告代码为HTML格式</td>
		</tr>
		<tr class="firstalt">
			<td>&nbsp;</td>
          <td >
            <input class="bginput" type="submit" name="submit" value=" 添加 " >
            <input class="bginput" type="button" onclick="history.back();" name="Input" value=" 返回 " >
          </td>
        </tr>
	</form>
    </table>
<?php }
?>
		

  </div>
</div>
<?php include "footer.php";
?>
</body>
</htm