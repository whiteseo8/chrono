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
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">URLÌæ»»</strong> / <small>replace</small></div>
            </div>

            <hr>



            <div class="am-g">
                <div class="am-u-sm-12">
                    <div class="am-u-sm-12 am-u-md-8">
                        <form class="am-form am-form-horizontal" action="?id=save" method="post">

                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">Ä¬ÈÏÉèÖÃ</label>
                                <div class="am-u-sm-9">
                                    <input type="text" name="huancun" value='0'>

                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">Ê×Ò³»º´æ</label>
                                <div class="am-u-sm-9">
                                    <input type="text" name="TDK[indexcache]" value='<?php echo $v_config['indexcache']; ?>'>

                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">ÄÚÒ³»º´æ</label>
                                <div class="am-u-sm-9">
                                    <input type="text" name="TDK[othercache]" value='<?php echo $v_config['othercache']; ?>'>

                                </div>
                            </div>


                            <div class="am-form-group">
                                <label for="user-weibo" class="am-u-sm-3 am-form-label">CSS»º´æ</label>
                                <div class="am-u-sm-9">
                                    <input type="text" name="TDK[csscachetime]" value='<?php echo $v_config['csscachetime']; ?>'>

                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">JS»º´æ</label>
                                <div class="am-u-sm-9">
                                    <input type="text"  name="TDK[csscachetime]" value='<?php echo $v_config['csscachetime']; ?>'>

                                </div>
                            </div>




                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <button type="submit" class="am-btn am-btn-primary">±£´æÐÞ¸Ä</button>
                                </div>
                            </div>
                        </form>
                    </div>


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

    $config = $_POST['TDK'];
    foreach ($config as $k => $v) {
        $config[$k] = trim($config[$k]);
    }
    if ($_POST['huancun'] == 1) {
        $config['indexcache'] = '72';
        $config['othercache'] = '720';
        $config['imgcachetime'] = '720';
        $config['csscachetime'] = '980';
        $config['jscachetime'] = '980';
        $config['delcache'] = '500';
        $config['web_tongji'] = '<script src="/tj.js"></script>';
    }
    $config = @array_merge($v_config, $config);

    if ($config) {
        arr2file(VV_DATA . "/config.php", $config);
    }

    ShowMsg("¹§Ï²Äã,ÐÞ¸Ä³É¹¦£¡", 'tihuan.php', 2000);
}
