<?php require_once("data.php");
$v_config = require_once("../data/config.php");
$v_change = require_once("../data/config/1.php");
require_once("checkAdmin.php");
$id = isset($_GET['id']) ? $_GET['id'] : '';
include("head.php");
if ($id == 'man' || $id == '') { ?>

    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">��������</strong> /
                    <small>TDK setting</small>
                </div>
            </div>

            <hr/>

            <div class="am-g">

                <div class="am-u-sm-12 am-u-md-8">
                    <form class="am-form am-form-horizontal" action="?id=save" method="post">

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">�ҵ���ַ / MyUrl</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="con[web_url]" id="web_url"
                                       value="<?php echo $v_config['web_url']; ?>">
                                <small>��http://��ͷ,б��"/"��β</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">Ŀ��վ��ַ / MyUrl</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="change[from_url]" id="from_url"
                                       value="<?php echo $v_change['from_url']; ?>">

                            </div>
                        </div>


                        <div class="am-form-group">
                            <label for="user-weibo" class="am-u-sm-3 am-form-label">��վ���� / WebName</label>
                            <div class="am-u-sm-9">
                                <input type="text" type="text" name="con[web_name]"
                                       value="<?php echo $v_config['web_name']; ?>">
                                <small>���ؼ��ʣ�1����</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">���� / Title</label>
                            <div class="am-u-sm-9">
                                <input type="text" name="con[web_seo_name]"
                                       value="<?php echo $v_config['web_seo_name']; ?>">
                                <small>��ҳ���⣬����30�����֡�</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-email" class="am-u-sm-3 am-form-label">�ؼ��� / Keywords</label>
                            <div class="am-u-sm-9">
                                <input name="con[web_keywords]" type="text"
                                       value="<?php echo $v_config['web_keywords']; ?>">
                                <small>��ҳ�ؼ��ʣ�2-3����Ϊ�ѣ�1��Ҳ�ɡ�</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">���� / Description</label>
                            <div class="am-u-sm-9">
                                <textarea rows="3" name="con[web_description]" ><?php echo $v_config['web_description']; ?></textarea>
                                <small>��ҳ������80���������ҡ�</small>
                            </div>
                        </div>


                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button type="submit" class="am-btn am-btn-primary">�����޸�</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="admin-content-footer">
            <hr>
            <p class="am-padding-left">&copy; 2017 Winbo, Inc. Licensed under MIT license.</p>
        </footer>

    </div>
    <!-- content end -->

    </div>

    <a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu"
       data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

    <script src="/public/assets/js/jquery.min.js"></script>
    <script src="/public/assets/js/amazeui.min.js"></script>

    <script src="/public/assets/js/app.js"></script>
    <script type="text/javascript">
        function msg(id, str) {
            if (id == 'error') return '<span class="error_msg">' + str + '</span>';
            if (id == 'success') return '<span class="success_msg">' + str + '</span>';
        }

        function checkurl(id) {
            var url = $('#' + id).val();
            if (url == '' || url.substr(0, 7) != 'http://' || url.substr(-1, 1) != '/') {
                $('#' + id + '_msg').html(msg('error', '��ַ��ʽ����ȷ��'));
            } else {
                $('#' + id + '_msg').html(msg('success', '��д��ȷ'));
            }
        }
    </script>
    </body>
    </html>
<?php } elseif ($id == 'save') {
    $config = $_POST['con'];
    foreach ($config as $k => $v) {
        $config[$k] = trim($config[$k]);
    }
    $config['web_tongji'] = get_magic($config['web_tongji']);
    if (substr($config['web_url'], -1) != '/') ShowMsg("��վ��ַ��ʽ����ȷ", '-1', 3000);
    if (!$v_config) $v_config = $config;
    $config = @array_merge($v_config, $config);
    $tihuan = $_POST['change'];
    foreach ($tihuan as $k => $v) {
        $tihuan[$k] = trim($tihuan[$k]);
    }
    $tihuan = @array_merge($v_change, $tihuan);

    if ($config && $tihuan) {
        arr2file(VV_DATA . "/config.php", $config);
        arr2file(VV_DATA . "/config/1.php", $tihuan);
    }
    ShowMsg("�޸ĳɹ���", 'admin.php', 2000);
}
?>