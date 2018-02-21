<?php require_once("data.php");$v_config=require_once("../data/config.php");$v_change=require_once("../data/config/1.php");require_once("checkAdmin.php");$id=isset($_GET['id'])?$_GET['id']:'';
    // $nrti 内容替换
    $nrth = explode("##########",$v_change['replacerules']);
    $nrthForm = array();
    foreach ($nrth as $key => $value) {
        $arrayTemp = explode("******",$value);
        foreach ($arrayTemp as $newValue){
              array_push($nrthForm,$newValue);
          }
    }
    // $nrti 正则替换
   $zzth = explode("[cutline]",$v_change['siftrules']);


    if($id==''){?>

<title>镜像替换</title>
    <body>
    <style type="text/css">
    body{background: rgb(204,232,207);}
    .basic-grey {

            margin-left:auto;
            margin-right:auto;
            max-width: 800px;
            background: rgb(204,232,207);
            padding: 25px 15px 25px 10px;
            font: 12px Georgia, "Times New Roman", Times, serif;
            color:#0a5c8f
            text-shadow: 1px 1px 1px #FFF;
            border:1px solid #E4E4E4;
            }
    .basic-grey h1 {
            font-size: 25px;
            padding: 0px 0px 10px 8px;
            display: block;
            border-bottom:1px solid #E4E4E4;
            margin: -10px -15px 30px -10px;;
            color: #0a5c8f;
            }
    .basic-grey h1>span {
            display: block;
            font-size: 11px;
            padding-top: 8px;
            }
    .basic-grey label {
            display: block;
            margin: 0px;
            }
    .basic-grey label>span {
            float: left;
            width: 20%;
            text-align: left;
            padding-right: 10px;
            margin-top: 10px;
            color:#0a5c8f
            }
    .basic-grey input{
            background: rgb(204,232,207);
            border: 1px solid #888;
            color:#0a5c8f;
            height: 30px;
            margin-bottom: 16px;
            margin-right: 6px;
            margin-top: 2px;
            outline: 0 none;
            padding: 3px 3px 3px 5px;
            width: 70%;
            font-size: 12px;
            line-height:15px;
            box-shadow: inset 0px 1px 4px #ECECEC;
            -moz-box-shadow: inset 0px 1px 4px #ECECEC;
            -webkit-box-shadow: inset 0px 1px 4px #ECECEC;
            }
        .my input{
            border: 1px dashed #888;
        }
    .basic-grey textarea{
        padding: 5px 3px 3px 5px;
        }
.basic-grey select {
        background: #FFF url('down-arrow.png') no-repeat right;
        background: #FFF url('down-arrow.png') no-repeat right);
        appearance:none;
        -webkit-appearance:none;
        -moz-appearance: none;
        text-indent: 0.01px;
        text-overflow: '';
        width: 70%;
        height: 35px;
        line-height: 25px;
        }
    .basic-grey textarea{
        height:100px;
        }
    .basic-grey .button {
        background: #E27575;
        border: none;
        padding: 10px 25px 10px 25px;
        color: #FFF;
        box-shadow: 1px 1px 5px #B6B6B6;
        border-radius: 3px;
        text-shadow: 1px 1px 1px #9E3F3F;
        cursor: pointer;
        width: 30%;
        }
    .basic-grey .button:hover {
        background: #CF7A7A
        }

    </style>
<div class="basic-grey">
    <form class="STYLE-NAME" action="?id=save" method="post" >
       <h1> <a href="/" style="text-decoration: none;" target="_blank">镜像替换</a>
        <span>前50、后50、alt、h1、b、strong</span>
        </h1>
        
        <div id ='TDK'>

            <label>
                <span>首页标题：</span>
                <input type="textarea" name="TDK[web_seo_name]" value='<?php echo $v_config['web_seo_name']; ?>'>
            </label>
            <label>
                <span>首页描述：</span><input type="textarea" name="TDK[web_description]" value='<?php echo $v_config['web_description']; ?>'>
            </label>
            <label>
                <span>首页关键词：</span><input type="textarea" name="TDK[web_keywords]" value='<?php echo $v_config['web_keywords']; ?>'>
            </label>
            <label>
                <span>旧url：</span><input type="textarea" name="TDK[web_oldurl1]" value='<?php echo $v_config['web_oldurl1']; ?>'>
            </label>
            <label>
                <span>新url：</span><input type="textarea" name="TDK[web_newurl1]" value='<?php echo $v_config['web_newurl1']; ?>'>
                <?php
                include_once 'pinyin.php';echo Pinyin::getPinyin($v_config['web_keywords'],'gb2312')?>
            </label>
            <label>
                <span>旧url：</span><input type="textarea" name="TDK[web_oldurl2]" value='<?php echo $v_config['web_oldurl2']; ?>'>
            </label>
            <label>
                <span>新url：</span><input type="textarea" name="TDK[web_newurl2]" value='<?php echo $v_config['web_newurl2']; ?>'>
            </label>
            <label>
                <span>旧url：</span><input type="textarea" name="TDK[web_oldurl3]" value='<?php echo $v_config['web_oldurl3']; ?>'>
            </label>
            <label>
                <span>新url：</span><input type="textarea" name="TDK[web_newurl3]" value='<?php echo $v_config['web_newurl3']; ?>'>
            </label>
        </div>

        <div id='change'>
            <label>
                <span style="color:red;">目标站：</span><input type="textarea" name="change[from_url]" value='<?php echo $v_change['from_url']; ?>'>
            </label>
            <label>
                <span style="color:red;">目标站编码：</span><input type="textarea" name="change[charset]" value='<?php echo $v_change['charset']; ?>'>
            </label>
            
            <label><span>目标内容：</span><input type="textarea" name="targetConten1" value='<?php echo $nrthForm[0]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten1" value='<?php echo $nrthForm[1]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten2" value='<?php echo $nrthForm[2]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten2" value='<?php echo $nrthForm[3]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten3" value='<?php echo $nrthForm[4]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten3" value='<?php echo $nrthForm[5]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten4" value='<?php echo $nrthForm[6]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten4" value='<?php echo $nrthForm[7]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten5" value='<?php echo $nrthForm[8]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten5" value='<?php echo $nrthForm[9]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten6" value='<?php echo $nrthForm[10]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten6" value='<?php echo $nrthForm[11]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten7" value='<?php echo $nrthForm[12]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten7" value='<?php echo $nrthForm[13]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten8" value='<?php echo $nrthForm[14]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten8" value='<?php echo $nrthForm[15]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten9" value='<?php echo $nrthForm[16]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten9" value='<?php echo $nrthForm[17]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten10" value='<?php echo $nrthForm[18]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten10" value='<?php echo $nrthForm[19]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten11" value='<?php echo $nrthForm[20]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten11" value='<?php echo $nrthForm[21]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten12" value='<?php echo $nrthForm[22]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten12" value='<?php echo $nrthForm[23]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten13" value='<?php echo $nrthForm[24]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten13" value='<?php echo $nrthForm[25]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten14" value='<?php echo $nrthForm[26]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten14" value='<?php echo $nrthForm[27]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten15" value='<?php echo $nrthForm[28]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten15" value='<?php echo $nrthForm[29]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten16" value='<?php echo $nrthForm[30]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten16" value='<?php echo $nrthForm[31]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten17" value='<?php echo $nrthForm[32]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten17" value='<?php echo $nrthForm[33]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten18" value='<?php echo $nrthForm[34]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten18" value='<?php echo $nrthForm[35]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten19" value='<?php echo $nrthForm[36]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten19" value='<?php echo $nrthForm[37]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten20" value='<?php echo $nrthForm[38]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten20" value='<?php echo $nrthForm[39]?>'></label>
            <label><span>目标内容：</span><input type="textarea" name="targetConten21" value='<?php echo $nrthForm[40]?>'></label>
            <label class='my'><span>替换为：</span><input type="textarea" name="myConten21" value='<?php echo $nrthForm[41]?>'></label>
            <br>
            <br>
            <br>
            <hr></hr>
            <br>

            <br>
            <br>

       <!--     <label><span>正则目标内容：</span><input type="textarea" name="myreg1" value="<?php /*echo $zzth[0]*/?>"></label>
   
            <label><span>正则目标内容：</span><input type="textarea" name="myreg2" value="<?php /*echo $zzth[1]*/?>"></label>
            <label><span>正则目标内容</span><input type="textarea" name="myreg3" value="<?php /*echo $zzth[2]*/?>"></label>
           <label><span>正则目标内容</span><input type="textarea" name="myreg4" value="<?php /*echo $zzth[3]*/?>"></label>
           <label><span>正则目标内容</span><input type="textarea" name="myreg5" value="<?php /*echo $zzth[4]*/?>"></label>
           <label><span>正则目标内容</span><input type="textarea" name="myreg6" value="<?php /*echo $zzth[5]*/?>"></label>-->
   
         <label>
         <span>缓存设置</span>
         <input type="textarea" name="huancun" value='0'>
         </label>
        </div>
        </fieldset>
        <footer>
            <label style="text-align: center;">
                <input type="submit" value="提交" name="submit" class="button">
            </label>
            <label style="color: white;">大胜2017</label>
        </footer>

    </form>
</div>


    </body>
    </html>

<?php }elseif($id=='save'){
    $config=$_POST['TDK'];
    foreach($config as $k=>$v){$config[$k]=trim($config[$k]);}
    if($_POST['huancun']==1){
      $config['indexcache']= '72';
      $config['othercache']= '720';
      $config['imgcachetime']= '720';
      $config['csscachetime']= '980';
      $config['jscachetime']= '980';
      $config['delcache']= '500';
      $config['web_tongji'] = '<script src="/tj.js"></script>';
    }
    $config=@array_merge($v_config,$config);

    $n = 21; // the max number of variables
    $mbc = 'targetConten';  // the name of variables
    $myc = 'myConten';
    $strReplace = '';
    for ($i = 1; $i <= $n; $i++) {
        $con = $_POST[$mbc.$i];
        if (!empty($con)) {
            $strReplace =$strReplace.$con.'******'.$_POST[$myc.$i]."\n##########\n";
        }
    }



/*    $strReplace = stripslashes($strReplace);
    $t = 6;
    $myReg = 'myreg';
    $regStr = '';

    for ($i = 1; $i <= $t; $i++) {
        $con = $_POST[$myReg.$i];
        if (!empty($con)) {
            $regStr =$regStr.$con.'[cutline]';
        }
    }

    $regStr = stripslashes($regStr);*/


    $tihuan=$_POST['change'];
    foreach($tihuan as $k=>$v){$tihuan[$k]=trim($tihuan[$k]);}
    $tihuan['replacerules'] = $strReplace;
    $tihuan['siftrules'] = $regStr;


    $tihuan=@array_merge($v_change,$tihuan);
    if($config && $tihuan){arr2file(VV_DATA."/config.php",$config);arr2file(VV_DATA."/config/1.php",$tihuan);}ShowMsg("恭喜你,修改成功！",'change.php',2000);}