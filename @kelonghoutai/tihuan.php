<?php require_once("data.php");
$v_config = require_once("../data/config.php");
$v_change = require_once("../data/config/1.php");
require_once("checkAdmin.php");
include("head.php");
$id = isset($_GET['id']) ? $_GET['id'] : '';
// $nrti 内容替换
$nrth = explode("##########", $v_change['replacerules']);
$nrthForm = array();
foreach ($nrth as $key => $value) {
    $arrayTemp = explode("******", $value);
    foreach ($arrayTemp as $newValue) {
        array_push($nrthForm, $newValue);
    }
}
// $nrti 正则替换
$zzth = explode("[cutline]", $v_change['siftrules']);


if ($id == '') {
    ?>

    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">内容替换</strong> / <small>replace</small></div>
            </div>

            <hr>

            <div class="am-g">
                <div class="am-u-md-6 am-u-md-offset-6">
                    <div class="am-btn-toolbar am-fr">
                        <div class="am-btn-group am-btn-group-xs">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-header"></span> H1</button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-save"></span> ALT</button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-bold"></span> 黑体</button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form am-form-horizontal" action="?id=save" method="post">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-id">ID</th><th class="table-title">替换前</th><th class="table-type">替换后</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>

                                <td>1</td>

                                <td><input type="text" name="targetConten1" value='<?php echo str_replace("'","&#39;",$nrthForm[0]) ?>'></td>
                                <td><input type="text" name="myConten1" value='<?php echo str_replace("'","&#39;",$nrthForm[1]) ?>'></td>

                            </tr>
                            <tr>

                                <td>2</td>

                                <td><input type="text" name="targetConten2" value='<?php echo str_replace("'","&#39;",$nrthForm[2]) ?>'></td>
                                <td><input type="text" name="myConten2" value='<?php echo str_replace("'","&#39;",$nrthForm[3]) ?>'></td>

                            </tr>
                            <tr>

                                <td>3</td>

                                <td><input type="text" name="targetConten3" value='<?php echo str_replace("'","&#39;",$nrthForm[4]) ?>'></td>
                                <td><input type="text" name="myConten3" value='<?php str_replace("'","&#39;",$nrthForm[5]) ?>'></td>

                            </tr>
                            <tr>

                                <td>4</td>
                                <td><input type="text" name="targetConten4" value='<?php echo str_replace("'","&#39;",$nrthForm[6]) ?>'></td>
                                <td><input type="text" name="myConten4" value='<?php echo str_replace("'","&#39;",$nrthForm[7]) ?>'></td>

                            </tr>
                            <tr>

                                <td>5</td>

                                <td><input type="text" name="targetConten5" value='<?php echo str_replace("'","&#39;",$nrthForm[8]) ?>'></td>
                                <td><input type="text" name="myConten5" value='<?php echo str_replace("'","&#39;",$nrthForm[9]) ?>'></td>

                            </tr>
                            <tr>

                                <td>6</td>

                                <td><input type="text" name="targetConten6" value='<?php echo str_replace("'","&#39;",$nrthForm[10]) ?>'></td>
                                <td><input type="text" name="myConten6" value='<?php echo str_replace("'","&#39;",$nrthForm[11]) ?>'></td>

                            </tr>
                            <tr>

                                <td>7</td>

                                <td><input type="text" name="targetConten7" value='<?php echo str_replace("'","&#39;",$nrthForm[12]) ?>'></td>
                                <td><input type="text" name="myConten7" value='<?php echo str_replace("'","&#39;",$nrthForm[13]) ?>'></td>

                            </tr>
                            <tr>

                                <td>8</td>

                                <td><input type="text" name="targetConten8" value='<?php echo str_replace("'","&#39;",$nrthForm[14]) ?>'></td>
                                <td><input type="text" name="myConten8" value='<?php echo str_replace("'","&#39;",$nrthForm[15]) ?>'></td>

                            </tr>

                            </tbody>
                        </table>

                        <hr>
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-id">ID</th><th class="table-title">正则表达式</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>1</td>
                                <td><textarea rows="1" id="user-intro" name="myreg1">
<?php echo $zzth[0]; ?>
                      </textarea></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><textarea rows="1" id="user-intro" name="myreg2">
<?php echo $zzth[1]; ?>
                      </textarea></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><textarea rows="1" id="user-intro" name="myreg3">
<?php echo $zzth[2]; ?>
                      </textarea></td>
                            </tr>

                            </tbody>
                        </table>
                        <hr>


                        <div class="am-u-md-6 am-u-md-offset-6">  <button type="submit" class="am-btn am-btn-primary">提交</button></div>
                    </form>
                </div>

            </div>
        </div>

        <footer class="admin-content-footer">
            <hr>
            <p class="am-padding-left">&copy; 2017 Winbo, Inc. Licensed under MIT license.</p>
        </footer>

    </div>



<?php } elseif ($id == 'save') {
//    $config = $_POST['TDK'];
//    foreach ($config as $k => $v) {
//        $config[$k] = trim($config[$k]);
//    }
//    if ($_POST['huancun'] == 1) {
//        $config['indexcache'] = '72';
//        $config['othercache'] = '720';
//        $config['imgcachetime'] = '720';
//        $config['csscachetime'] = '980';
//        $config['jscachetime'] = '980';
//        $config['delcache'] = '500';
//        $config['web_tongji'] = '<script src="/tj.js"></script>';
//    }
//    $config = @array_merge($v_config, $config);

    $n = 16; // the max number of variables
    $mbc = 'targetConten';  // the name of variables
    $myc = 'myConten';
    $strReplace = '';
    for ($i = 1; $i <= $n; $i++) {
        $con = $_POST[$mbc . $i];
        if (!empty($con)) {
            $strReplace = $strReplace . $con . '******' . $_POST[$myc . $i] . "\n##########\n";
        }
    }


    $strReplace = stripslashes($strReplace);
    $t = 3;
    $myReg = 'myreg';
    $regStr = '';

    for ($i = 1; $i <= $t; $i++) {
        $con = $_POST[$myReg.$i];
        if (!empty($con)) {
            $regStr =$regStr.$con.'[cutline]';
        }
    }

    $regStr = stripslashes($regStr);



    $tihuan['replacerules'] = $strReplace;
    $tihuan['siftrules'] = $regStr;


    $tihuan = @array_merge($v_change, $tihuan);
    if ($tihuan) {
//        arr2file(VV_DATA . "/config.php", $config);
        arr2file(VV_DATA . "/config/1.php", $tihuan);
    }
    ShowMsg("恭喜你,修改成功！", 'tihuan.php', 2000);
}
