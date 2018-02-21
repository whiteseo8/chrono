<?php require_once("data.php");$v_config=require_once("../data/config.php");require_once("checkAdmin.php");
if(isset($_GET['del'])&&$_GET['del']=='yes'){@unlink(VV_DATA."/zhizhu.txt");ShowMsg("蜘蛛访问清除完毕！",'zhizhu.php',2000);}echo ADMIN_HEAD; ?>
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
}
p {	
	margin: 0 0 10px 5px;
}
.f {color: #CCCCCC}
-->
</style>

<body>

<div class="right">
  <?php include "welcome.php"; ?>
  <div class="right_main">

 <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
 <tr nowrap  class="tb_head">
      <td colspan="5"><h2>蜘蛛访问记录&nbsp;&nbsp;<a href="?del=yes" style='color:red'>清除记录</a></h2></td>
 </tr>
 <tr class="firstalt">
	<td colspan="5">为了性能，仅保留最近1万条记录</td>
 </tr>
<?php $file=VV_DATA."/zhizhu.txt";$type=isset($_GET['type'])?$_GET['type']:'';$result='';if(is_file($file)){$arr=file($file);$zongshu=count($arr);$count=array('baidu'=>0,'baidu_today'=>0,'baidu_yestoday'=>0,'360'=>0,'360_today'=>0,'360_yestoday'=>0,'google'=>0,'google_today'=>0,'google_yestoday'=>0,'shenma'=>0,'shenma_today'=>0,'shenma_yestoday'=>0,'sogou'=>0,'sogou_today'=>0,'sogou_yestoday'=>0,'yahoo'=>0,'yahoo_today'=>0,'yahoo_yestoday'=>0,'other'=>0,'other_today'=>0,'other_yestoday'=>0,);if($arr){foreach($arr as $i=>$v){if(trim($arr[$i])=='')continue;$id=$zongshu-$i;list($ip,$name,$url,$time)=explode("---",$arr[$i]);if($name=='Baidu'){$count['baidu']++;}else if($name=='360搜索'){$count['360']++;}else if($name=='Google'){$count['google']++;}else if($name=='神马搜索'){$count['shenma']++;}else if($name=='Sogou'){$count['sogou']++;}else if($name=='Yahoo!'){$count['yahoo']++;}else{$count['other']++;}if($type&&$type!=$name){continue;}if(date("Y-m-d")==date("Y-m-d",strtotime($time))){$time='<font color=red>'.$time.'</font>';if($name=='Baidu'){$count['baidu_today']++;}else if($name=='360搜索'){$count['360_today']++;}else if($name=='Google'){$count['google_today']++;}else if($name=='神马搜索'){$count['shenma_today']++;}else if($name=='Sogou'){$count['sogou_today']++;}else if($name=='Yahoo!'){$count['yahoo_today']++;}else{$count['other_today']++;}}if(date("Y-m-d",strtotime($time))==date("Y-m-d",strtotime("-1 day"))){if($name=='Baidu'){$count['baidu_yestoday']++;}else if($name=='360搜索'){$count['360_yestoday']++;}else if($name=='Google'){$count['google_yestoday']++;}else if($name=='神马搜索'){$count['shenma_yestoday']++;}else if($name=='Sogou'){$count['sogou_yestoday']++;}else if($name=='Yahoo!'){$count['yahoo_yestoday']++;}else{$count['other_yestoday']++;}}$url=htmlspecialchars($url);$href=$url;if(strlen($url)>65)$href=substr($url,0,65).'...';$url='<a target=_blank title="打开此链接" href='.$url.'>'.$href.'</a>';$result[]=array('id'=>$id,'name'=>$name,'ip'=>$ip,'url'=>$url,'time'=>$time);}$page=isset($_GET['page'])?$_GET['page']:1;$pagesize=15;$total=count($result);$totalpages=ceil($total/$pagesize);if($page>$totalpages){$page=$totalpages;}$result=array_slice($result,($page-1)*$pagesize,$pagesize);$pageurl='?page={!page!}';if($type){$pageurl.='&type='.$type;}$pages=get_page($page,$totalpages,$pageurl);}} ?>
<style type="text/css">
.page{clear:both;padding:20px 0;color:#0066ff;text-align:center;font-size:14px;}
.page span,.page a{display:inline-block;padding:2px 6px;}
.page span{margin:0 5px;color:#fff;background:#3399ff;}
.page a{color:#0066ff;margin:0 5px;border:1px solid #3399ff;border-radius:3px;font-weight:700;}
.page a:hover{color:#fff;background-color:#3399ff;text-decoration:none;}
.rtable td {border-bottom: 1px solid #EBEBEB;}
.rtable {background-color: #fff;}
.headt a{color:#3333cc}
</style>
<tr class="firstalt">
	<td colspan="5">
		<table width="98%" border="0" cellpadding="4" cellspacing="0" class="tableoutline rtable">
			<tr class="firstalt headt">
				<td>类型</td>
				<td><a href="?type=Baidu">百度</a></td>
				<td><a href="?type=360搜索">360</a></td>
				<td><a href="?type=Google">Google</a></td>
				<td><a href="?type=神马搜索">神马</a></td>
				<td><a href="?type=Sogou">Sogou</a></td>
				<td><a href="?type=Yahoo!">Yahoo!</a></td>
				<td>其他</td>
			</tr>
			<tr class="firstalt">
				<td><font color="red">今日</font></td>
				<td><?php echo $count['baidu_today']; ?></td>
				<td><?php echo $count['360_today']; ?></td>
				<td><?php echo $count['google_today']; ?></td>
				<td><?php echo $count['shenma_today']; ?></td>
				<td><?php echo $count['sogou_today']; ?></td>
				<td><?php echo $count['yahoo_today']; ?></td>
				<td><?php echo $count['other_today']; ?></td>
			</tr>
			<tr class="firstalt">
				<td>昨日</td>
				<td><?php echo $count['baidu_yestoday']; ?></td>
				<td><?php echo $count['360_yestoday']; ?></td>
				<td><?php echo $count['google_yestoday']; ?></td>
				<td><?php echo $count['shenma_yestoday']; ?></td>
				<td><?php echo $count['sogou_yestoday']; ?></td>
				<td><?php echo $count['yahoo_yestoday']; ?></td>
				<td><?php echo $count['other_yestoday']; ?></td>
			</tr>
			<tr class="firstalt">
				<td>合计</td>
				<td><?php echo $count['baidu']; ?></td>
				<td><?php echo $count['360']; ?></td>
				<td><?php echo $count['google']; ?></td>
				<td><?php echo $count['shenma']; ?></td>
				<td><?php echo $count['sogou']; ?></td>
				<td><?php echo $count['yahoo']; ?></td>
				<td><?php echo $count['other']; ?></td>
			</tr>
		</table>
	</td>
</tr>
<?php if($type){ ?>
	<tr nowrap class="firstalt">
		<td colspan="8"><font color="blue">当前为“ <font color="red"><?php echo $type; ?></font> ”的结果，<a href="?">查看全部</a></font></td>
	</tr>
	<?php } ?>
 <tr nowrap class="firstalt">
   <td width="50" height="30"><div align="center">ID</div></td>
   <td width="70"><div align="center">蜘蛛</div></td>
   <td width="120"><div align="center">蜘蛛IP</div></td>
   <td>来访页面</td>
   <td width="200">来访时间</td>
 </tr>
<?php if($result){foreach($result as $k=>$vo){ ?>
	<tr class="firstalt">
		<td><?php echo $vo['id']; ?></td>
		<td><?php echo $vo['name']; ?></td>
		<td><?php echo $vo['ip']; ?></td>
		<td><?php echo $vo['url']; ?></td>
		<td><?php echo $vo['time']; ?></td>
	</tr>
<?php } ?>
	<tr class="firstalt">
		<td align="center" colspan="5"><ul class="page"><?php echo $pages; ?></ul></td>
	</tr>
<?php }else{ ?>
	<tr align=center class="firstalt"><td colspan=5>暂时还没有蜘蛛访问</td></tr>
<?php } ?>
 </table>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</htm>