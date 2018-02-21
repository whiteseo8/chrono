<?php require_once("data.php");
$v_config = require_once("../data/config.php");

require_once("checkAdmin.php");
include("head.php");
$id = isset($_GET['id']) ? $_GET['id'] : '';



if ($id == '') {
    ?>

    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">URL替换</strong> / <small>replace</small></div>
            </div>

            <hr>

            <div class="am-g">
                <div class="am-u-md-6 am-u-md-offset-6">
                    <div class="am-btn-toolbar am-fr">
                        <div class="am-btn-group am-btn-group-xs">

                            <?php
                            include_once 'pinyin.php';
                            $keywords = explode(',',$v_config['web_keywords']) ?>
                            <div  class="am-hide" id="keyword1"><?php echo Pinyin::getPinyin($keywords[0], 'gb2312') ?></div>
                            <div  class="am-hide" id="keyword2"><?php echo Pinyin::getPinyin($keywords[1], 'gb2312') ?></div>
                            <div  class="am-hide" id="keyword3"><?php echo Pinyin::getPinyin($keywords[2], 'gb2312') ?></div>

                            <button type="button" onclick="copyToClipboard('#keyword1')" class="btn am-btn am-btn-default"> <?php echo Pinyin::getPinyin($keywords[0], 'gb2312') ?></button>
                            <button type="button" onclick="copyToClipboard('#keyword2')" class="am-btn am-btn-default"><?php echo Pinyin::getPinyin($keywords[1], 'gb2312') ?></button>
                            <button type="button" onclick="copyToClipboard('#keyword3')" class="am-btn am-btn-default"><?php echo Pinyin::getPinyin($keywords[2], 'gb2312') ?></button>
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-trash-o"></span> 清空</button>

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
                                <th class="table-id">ID</th><th class="table-title">原url</th><th class="table-type">新url</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>

                                <td>1</td>

                                <td><input type="text" name="TDK[web_oldurl1]" value='<?php echo $v_config['web_oldurl1']; ?>'></td>
                                <td><input type="text" name="TDK[web_newurl1]" value='<?php echo $v_config['web_newurl1']; ?>'></td>

                            </tr>
                            <tr>

                                <td>2</td>

                                <td><input type="text" name="TDK[web_oldurl2]" value='<?php echo $v_config['web_oldurl2']; ?>'></td>
                                <td><input type="text" name="TDK[web_newurl2]" value='<?php echo $v_config['web_newurl2']; ?>'></td>

                            </tr>
                            <tr>

                                <td>3</td>

                                <td><input type="text" name="TDK[web_oldurl3]" value='<?php echo $v_config['web_oldurl3']; ?>'></td>
                                <td><input type="text" name="TDK[web_newurl3]" value='<?php echo $v_config['web_newurl3']; ?>'></td>

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
   $config = $_POST['TDK'];
    foreach ($config as $k => $v) {
        $config[$k] = trim($config[$k]);
   }

 $config = @array_merge($v_config, $config);

    if ($config) {
        arr2file(VV_DATA . "/config.php", $config);
    }

    ShowMsg("恭喜你,修改成功！", 'tihuan.php', 2000);
}
