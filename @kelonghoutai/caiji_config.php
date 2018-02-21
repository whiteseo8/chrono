<?php require_once("data.php");
$v_config = require_once("../data/config.php");
require_once("checkAdmin.php");
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
$ac = isset($_GET['ac']) ? $_GET['ac'] : '';
if ($ac == 'del') {
    $file = VV_DATA . '/config/' . $id . '.php';
    if (@unlink($file)) ShowMsg("��ϲ��,ɾ���ɹ���", 'caiji_config.php', 500);
}
if ($ac == 'yulan') {
    require(VV_INC . "/caiji.class.php");
    require(VV_DATA . '/rules.php');
    exit;
}
if ($ac == 'savecollectid') {
    $config = array('collectid' => $_GET['collectid']);
    $config = @array_merge($v_config, $config);
    if ($config) {
        arr2file(VV_DATA . "/config.php", $config);
    }
    ShowMsg("��ϲ��,�޸ĳɹ���", 'caiji_config.php', 500);
}
if ($ac == 'status') {
    $collectid = (int)$_GET['collectid'];
    $file = VV_DATA . '/config/' . $collectid . '.php';
    $sid = intval($_GET['sid']);
    if (!is_file($file)) ShowMsg("�ɼ������ļ�������", '-1', 2000);
    $caiji_config = require_once($file);
    if ($caiji_config) {
        $caiji_config['collect_close'] = $sid;
        arr2file($file, $caiji_config);
    }
    ShowMsg("��ϲ��,�޸ĳɹ���", '?', 500);
}
if ($ac == 'save') {
    $config = $_POST['con'];
    foreach ($config as $k => $vo) {
        if (is_array($config[$k])) {
            foreach ($config[$k] as $kk => $vv) {
                $config[$k][$kk] = utf2gbk(get_magic(trim($vv)));
            }
        } else {
            $config[$k] = utf2gbk(get_magic(trim($config[$k])));
        }
    }
    $zdy = $_POST['zdy'];
    if ($zdy) {
        foreach ($zdy as $k => $vo) {
            foreach ($vo as $kk => $vv) {
                $zdy[$k][$kk] = utf2gbk(get_magic(trim($vv)));
                if (in_array($kk, array('name', 'ename')) && $zdy[$k][$kk] == '') {
                    unset($zdy[$k]);
                }
            }
        }
    }
    $config['zdy'] = $zdy;
    if ($config['replacerules']) {
        if (!preg_match('#\{vivicut\}#', $config['replacerules'])) {
        }
    }
    if ($config['plus']) {
        $config['plus'] = implode(',', $config['plus']);
    } else {
        $config['plus'] = '';
    }
    if ($config['siftrules']) {
        $config['siftrules'] = str_replace(array("\r\n", "\r", "\n"), '[cutline]', $config['siftrules']);
        $siftrules = explode('[cutline]', $config['siftrules']);
        foreach ($siftrules as $k => $vo) {
            if (!preg_match('#\{vivi\s+replace\s*=\s*\'([^\']*)\'\s*\}(.*)\{/vivi\}$#', trim($vo))) {
                ajaxReturn(array('status' => 0, 'info' => "���˹����������ʽ��ʽ����ȷ"));
            }
        }
        $config['siftrules'] = implode("[cutline]", $siftrules);
    }
    if ($config['replacerules_before']) {
        if (!preg_match('#\{vivicut\}#', $config['replacerules_before'])) {
        }
    }
    if ($config['siftrules_before']) {
        $config['siftrules_before'] = str_replace(array("\r\n", "\r", "\n"), '[cutline]', $config['siftrules_before']);
        $siftrules_before = explode('[cutline]', $config['siftrules_before']);
        foreach ($siftrules_before as $k => $vo) {
            if (!preg_match('#\{vivi\s+replace\s*=\s*\'([^\']*)\'\s*\}(.*)\{/vivi\}$#', trim($vo))) {
                ajaxReturn(array('status' => 0, 'info' => "���˹����������ʽ��ʽ����ȷ"));
            }
        }
        $config['siftrules_before'] = implode("[cutline]", $siftrules_before);
    }
    $file = VV_DATA . '/config/' . $id . '.php';
    if (is_file($file)) {
        $caiji_config = require_once($file);
        $config = array_merge($caiji_config, $config);
    }
    $config = array_merge($config, array('siftags' => @$_POST['siftags'], 'time' => time()));
    $result = arr2file($file, $config);
    if ($result === false) {
        ajaxReturn(array('status' => 1, 'info' => "�޸�ʧ�ܣ�����ļ�д��Ȩ�ޣ�"));
    }
    ajaxReturn(array('status' => 1, 'info' => "��ϲ��,�޸ĳɹ���"));
}
if ($ac == 'saveimport') {
    $text = trim($_POST['import_text']);
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if (!$id) {
        $arr = glob(VV_DATA . '/config/*.php');
        if (!OoO0o0O0o() && count($arr) >= 2) ShowMsg('����ʧ�ܣ�δ��Ȩֻ����2������', '-1', 6000);
        if ($arr) {
            $arr = array_map('basename', $arr);
            $arr = array_map('intval', $arr);
            $id = max($arr) + 1;
        }
    }
    if (!$id) {
        $id = 1;
    }
    $file = VV_DATA . '/config/' . $id . '.php';
    if (preg_match('#^VIVI:#', $text)) {
        if (!preg_match('#:END$#', $text)) {
            ShowMsg('�ù��򲻺Ϸ����ɼ�����Ϊ��VIVI:base64����:END !', '-1', 6000);
        }
        $notess = explode(':', $text);
        $config = $notess[1];
        $config = unserialize(base64_decode(preg_replace("#[\r\n\t ]#", '', $config))) OR die('�����ַ����д���');
    } else {
        ShowMsg("�ù��򲻺Ϸ����޷����룡", '-1', 6000);
    }
    arr2file($file, $config);
    ShowMsg("��ϲ��,����ɹ���", 'caiji_config.php', 2000);
}
echo ADMIN_HEAD; ?>
<body>
<div class="right">
    <?php include "welcome.php"; ?>
    <div class="right_main">
        <?php if ($ac == ''){
            $dir = VV_DATA . '/config';
            $filearr = scandirs($dir);
            $temp = array();
            foreach ($filearr as $file) {
                if ($file <> '.' && $file <> '..') {
                    if (is_file("$dir/$file")) {
                        if (!preg_match('#^\d+\.php$#', $file)) {
                            continue;
                        }
                        $thisid = str_replace('.php', '', $file);
                        $file = VV_DATA . '/config/' . $file;
                        $caiji_config = require_once($file);
                        $temp[] = array_merge($caiji_config, array('id' => $thisid));
                    }
                }
            }
            foreach ($temp as $key => $row) {
                $volume[$key] = $row['id'];
            }
            @array_multisort($volume, SORT_DESC, $temp);
            if (!OoO0o0O0o()) $temp = array_slice($temp, 0, 2); ?>
            <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
                <tbody>
                <tr nowrap class="tb_head">
                    <td colspan="8">�ɼ��ڵ����&nbsp;&nbsp;-&nbsp;<a href="?ac=add" style='color:red'>���</a>&nbsp;-&nbsp;<a
                                href="?ac=import" style='color:red'>����</a>&nbsp;-&nbsp;<a href="http://www.vxiaotou.com"
                                                                                          target="_blank"
                                                                                          style='color:red'>��ȡ�������</a>
                    </td>
                </tr>
                </tbody>
                <tr nowrap class="firstalt">
                    <td colspan="8"><font color="#dd00b0">ע���ɼ�����Ϊ�ر�ʱ����ֹͣ�ɼ���ʹ�û��棡</font></td>
                </tr>
                <?php if (!OoO0o0O0o()) { ?>
                    <tr nowrap class="firstalt">
                        <td colspan="8" align="center"><font color="blue">δ��Ȩֻ����2������</font></td>
                    </tr>
                <?php } ?>
                <tr nowrap class="firstalt">
                    <td width="60" align="center">Ĭ��</td>
                    <td width="50" align="center">ID</td>
                    <td align="center">�ڵ�����</td>
                    <td width="70" align="center">�ɼ�����</td>
                    <td width="70" align="center">˵��(�������)</td>
                    <td width="100" align="center">����</td>
                    <td width="130" align="center">�޸�ʱ��</td>
                    <td width="250" align="center">����</td>
                </tr>
                <?php if ($temp) {
                    foreach ($temp as $k => $vo) { ?>
                        <tr nowrap class="firstalt">
                            <td width="60"
                                align="center"><?php echo $vo['id'] == $v_config['collectid'] ? '<font color="red">Ĭ�Ͻڵ�</font>' : '<a href="?ac=savecollectid&collectid=' . $vo['id'] . '&sid=0" title="�����ΪĬ�Ͻڵ�">��ΪĬ��</a>'; ?></td>
                            <td width="50" align="center"><?php echo $vo['id'] ?></td>
                            <td style="padding-left:20px"><a
                                        href="?ac=xiugai&id=<?php echo $vo['id'] ?>"><?php echo $vo['name'] ?></a></td>
                            <td align="center"><?php echo $vo['collect_close'] ? '<a href="?ac=status&collectid=' . $vo['id'] . '&sid=0" title="�������"><font color="red">�ѹر�</font></a>' : '<a href="?ac=status&collectid=' . $vo['id'] . '&sid=1" title="����ر�"><font color="green">�ѿ���</font></a>'; ?></td>
                            <td width="100" align="center"><a href="javascript:"
                                                              onclick='alert("<?php echo !empty($vo['licence']) ? str_replace(array("\r\n", "\r", "\n"), '\\n', $vo['licence']) : '��'; ?>");'>����</a>
                            </td>
                            <td width="100" align="center"><?php echo $vo['charset'] ?></td>
                            <td width="150" align="center"><?php echo date('Y-m-d H:i:s', $vo['time']) ?></td>
                            <td width="200" align="center"><a target="_blank"
                                                              href="?ac=yulan&collectid=<?php echo $vo['id'] ?>">Ԥ��Դ����</a>&nbsp;&nbsp;<a
                                        href="?ac=xiugai&id=<?php echo $vo['id'] ?>">�޸�</a>&nbsp;&nbsp;<a
                                        href="?ac=export&id=<?php echo $vo['id'] ?>">����</a>&nbsp;&nbsp;<a
                                        href="?ac=import&id=<?php echo $vo['id'] ?>">����</a>&nbsp;&nbsp;<a
                                        href="?ac=del&id=<?php echo $vo['id'] ?>"
                                        onClick="return confirm('ȷ��ɾ��?')">ɾ��</a></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr nowrap class="firstalt">
                        <td colspan="8" align="center">û���ҵ��ɼ��ڵ㣡</td>
                    </tr>
                <?php } ?>

            </table>
        <?php } elseif ($ac == 'export') {
            $file = VV_DATA . '/config/' . $id . '.php';
            if (!is_file($file)) ShowMsg("�ɼ������ļ�������", '-1', 2000);
            $caiji_config = require_once($file);
            $basecon = "VIVI:" . base64_encode(serialize($caiji_config)) . ":END"; ?>
            <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
                <tbody>
                <tr nowrap class="tb_head">
                    <td><h2>�����ɼ�����</h2></td>
                </tr>
                </tbody>
                <tr nowrap class="firstalt">
                    <td><b>����Ϊ���� [<?php echo $caiji_config['name']; ?>] �����ã�����Թ�����������:</b></td>
                </tr>
                <tr nowrap class="firstalt">
                    <td align="center"><textarea style="height: 350px;width:95%;padding:5px;background:#eee;"
                                                 onFocus="this.style.borderColor='#00CC00'"
                                                 onBlur="this.style.borderColor='#dcdcdc'"><?php echo $basecon; ?></textarea>
                    </td>
                </tr>
            </table>
        <?php } elseif ($ac == 'import') {
            $tinfo = '';
            if ($id) {
                $file = VV_DATA . '/config/' . $id . '.php';
                if (!is_file($file)) ShowMsg("�ɼ������ļ�������", '-1', 3000);
                $caiji_config = require_once($file);
                $tinfo = '( ����[' . $caiji_config['name'] . ']��)<input type="hidden" name="id" value="' . $id . '" />';
            } ?>
            <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
                <form action="?ac=saveimport" method="post">
                    <tbody>
                    <tr nowrap class="tb_head">
                        <td><h2>����ɼ�����</h2></td>
                    </tr>
                    </tbody>
                    <tr nowrap class="firstalt">
                        <td><b>��������������Ҫ����Ĳɼ�����</b><font color="red"><?php echo $tinfo ?></font>��</td>
                    </tr>
                    <tr nowrap class="firstalt">
                        <td align="center"><textarea name="import_text"
                                                     style="height: 350px;width:95%;padding:5px;background:#eee;"
                                                     onFocus="this.style.borderColor='#00CC00'"
                                                     onBlur="this.style.borderColor='#dcdcdc'"></textarea></td>
                    </tr>
                    <tbody>
                    <tr class="firstalt">
                        <td align="center" colspan="2">
                            <input type="submit" value=" �ύ " name="submit" class="bginput">&nbsp;&nbsp;<input
                                    type="button" onclick="history.go(-1);" value=" ���� " name="Input" class="bginput">
                        </td>
                    </tr>
                    </tbody>
                </form>
            </table>
        <?php }
        elseif ($ac == 'xiugai' || $ac == 'add'){
        if ($ac == 'xiugai') {
            $file = VV_DATA . '/config/' . $id . '.php';
            if (!is_file($file)) ShowMsg("�ɼ������ļ�������", '-1', 3000);
            $caiji_config = require_once($file);
            if ($caiji_config['siftrules']) {
                $caiji_config['siftrules'] = implode("\r\n", explode('[cutline]', $caiji_config['siftrules']));
            }
            if ($caiji_config['siftrules_before']) {
                $caiji_config['siftrules_before'] = implode("\r\n", explode('[cutline]', $caiji_config['siftrules_before']));
            }
            if (empty($caiji_config['siftags'])) $caiji_config['siftags'] = array('123');
            $caiji_config['resdomain'] = $caiji_config['resdomain'] ? $caiji_config['resdomain'] : $caiji_config['other_imgurl'];
        } else {
            $caiji_config = array('name' => '', 'replace' => '', 'charset' => 'gb2312', 'from_url' => '', 'resdomain' => '', 'siftags' => array(), 'siftrules' => '', 'replacerules' => '', 'rewrite' => '', 'licence' => '', 'from_title' => '', 'search_url' => '',);
            $arr = glob(VV_DATA . '/config/*.php');
            $id = 1;
            if ($arr) {
                $arr = array_map('basename', $arr);
                $arr = array_map('intval', $arr);
                $id = max($arr) + 1;
            }
        } ?>
        <script type="text/javascript">
            function tab(no, n) {
                for (var i = 1; i <= n; i++) {
                    $('#tab' + i).removeClass('cur');
                    $('#config' + i).hide();
                }
                $('#config' + no).fadeIn();
                $('#tab' + no).addClass('cur');
            }
        </script>
        <style type="text/css">
            li.cur {
                background: #eefffd;
            }
        </style>
        <div id="dialog"></div>
        <form action="?ac=save&id=<?php echo $id ?>" method="post" id="form">
            <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
                <tbody>
                <tr nowrap class="tb_head">
                    <td colspan="2">
                        <div style='float:left;padding:5px;'>�ɼ��ڵ����ã�</div>&nbsp;&nbsp;<div
                                style='float:left;padding:5px;border:1px dotted #ff6600;background:#ffffee'>
                            �����滻�������ڳ�����֮��ִ�У��밴�ղɼ����ҳ��Դ������б�д������Ŀ��վԭʼԴ���룬������<font color="red">��վǰ̨</font>ҳ��鿴Դ����
                        </div>
                    </td>
                </tr>
                <tr class="firstalt">
                    <td colspan="2">
                        <ul class="do_nav">
                            <li id="tab1" class="cur"><a onclick="tab(1,6);" href="javascript:">��������</a></li>
                            <li id="tab2"><a onclick="tab(2,6);" href="javascript:">�滻����</a></li>
                            <li id="tab3"><a onclick="tab(3,6);" href="javascript:">�Զ����ǩ</a></li>
                            <li id="tab4"><a onclick="tab(4,6);" href="javascript:">�Զ���css</a></li>
                            <li id="tab5"><a onclick="tab(5,6);" href="javascript:">�߼�����</a><img
                                        src="../public/img/vip.gif" style="cursor: pointer;vertical-align: middle;"
                                        title="vip����" width="19" height="18"/></li>
                            <li id="tab6"><a onclick="tab(6,6);" href="javascript:">�Ʒ��ɼ�</a><img
                                        src="../public/img/vip.gif" style="cursor: pointer;vertical-align: middle;"
                                        title="vip����" width="19" height="18"/></li>
                        </ul>
                    </td>
                </tr>
                </tbody>
                <tbody id="config1">
                <tr nowrap class="firstalt">
                    <td width="260"><b>�ڵ�����</b><br>
                        <font color="#666666">����Ĳɼ���һ������</font></td>
                    <td><input type="text" name="con[name]" size="50" value="<?php echo $caiji_config['name']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>Ŀ����վ����</b><br>
                        <font color="#666666">����÷��� * �ָ�</font><br><font color="red">ע����Ҫֻ��д��ĸ���������������滻����</font></td>
                    <td><input type="text" name="con[from_title]" id="from_title" size="50"
                               value="<?php echo $caiji_config['from_title']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>Ŀ��վ��ַ</b><br>
                        <font color="#666666">��Ҫ�ɼ���Ŀ����վ��ַ</font><br><font color="red">ע��http://��https://��ͷ</font></td>
                    <td><input type="text" name="con[from_url]" id="from_url" size="50"
                               value="<?php echo $caiji_config['from_url']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">&nbsp;<select
                                name="con[charset]">
                            <option value="auto" <?php if ($caiji_config['charset'] == 'auto' || empty($caiji_config['charset'])) echo " selected"; ?>>
                                �Զ�ʶ��
                            </option>
                            <option value="gb2312" <?php if ($caiji_config['charset'] == 'gb2312') echo " selected"; ?>>
                                gb2312
                            </option>
                            <option value="utf-8" <?php if ($caiji_config['charset'] == 'utf-8') echo " selected"; ?>>
                                utf-8
                            </option>
                            <option value="gbk" <?php if ($caiji_config['charset'] == 'gbk') echo " selected"; ?>>gbk
                            </option>
                            <option value="big5" <?php if ($caiji_config['charset'] == 'big5') echo " selected"; ?>>
                                big5
                            </option>
                        </select>&nbsp;Ŀ��վ����
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>��������</b><br>
                        <font color="#666666">Ŀ��վ���������һ��վ��ʱ��д<br>ÿ�������ð�Ƕ��ŷָ�<br>
                            <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>��: baidu.com<font
                                        color="red">,</font>www.baidu.com
                            </div>
                        </font></td>
                    <td><input type="text" name="con[other_url]" id="other_url" size="50"
                               value="<?php echo $caiji_config['other_url']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>Ŀ��վ��Դ����</b><br>
                        <font color="#666666">����д��Ҫ�ɼ���cssͼƬ����Դ����<br>ÿ�������ð�Ƕ��ŷָ�<br>
                            <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>��: img1.baidu.com<font
                                        color="red">,</font>*.baidu.com
                            </div>
                        </font></td>
                    <td><input type="text" name="con[resdomain]" id="resdomain" size="50"
                               value="<?php echo $caiji_config['resdomain']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>ͼƬ��������</b><br>
                        <font color="#666666">��Ŀ��վͼƬʹ���ӳټ��ص�ʱ��ʹ��<br>ÿ���ð�Ƕ��ŷָ�<br>
                            <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>��: data-src<font
                                        color="red">,</font>_src
                            </div>
                        </font></td>
                    <td><input type="text" name="con[img_delay_name]" size="50"
                               value="<?php echo $caiji_config['img_delay_name']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                        <font color="red">һ�㲻������</font></td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>Ŀ��վ������ַ</b><br>
                        <font color="#666666">Ŀ��վ������ַ����������Ҫ����</font></td>
                    <td><input type="text" name="con[search_url]" id="search_url" size="50"
                               value="<?php echo $caiji_config['search_url']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">&nbsp;<select
                                name="con[search_charset]">
                            <option value="gb2312" <?php if ($caiji_config['search_charset'] == 'gb2312' || empty($caiji_config['search_charset'])) echo " selected"; ?>>
                                gb2312
                            </option>
                            <option value="utf-8" <?php if ($caiji_config['search_charset'] == 'utf-8') echo " selected"; ?>>
                                utf-8
                            </option>
                            <option value="gbk" <?php if ($caiji_config['search_charset'] == 'gbk') echo " selected"; ?>>
                                gbk
                            </option>
                            <option value="big5" <?php if ($caiji_config['search_charset'] == 'big5') echo " selected"; ?>>
                                big8
                            </option>
                        </select>&nbsp;����ҳ��ı���
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>����js����</b><br>
                        <font color="#666666">�Ƿ�����js����</font></td>
                    <td><select name="con[hidejserror]">
                            <option value="0" <?php if ($caiji_config['hidejserror'] == '0') echo " selected"; ?>>�ر�
                            </option>
                            <option value="1" <?php if ($caiji_config['hidejserror']) echo " selected"; ?>>����</option>
                        </select></td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>��ֹ�ƶ�����ת��</b><br>
                        <font color="#666666">��ѡ��ɽ�ֹ�ٶ��ƶ�����ת��</font></td>
                    <td><select name="con[no_siteapp]">
                            <option value="0" <?php if ($caiji_config['no_siteapp'] == '0') echo " selected"; ?>>�ر�
                            </option>
                            <option value="1" <?php if ($caiji_config['no_siteapp']) echo " selected"; ?>>����</option>
                        </select></td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260" valign='top'><b>ʹ��˵��</b><br>
                        <font color="#666666">��д������Ϣ��ʹ��Э���˵����ע������</font></td>
                    <td><textarea name="con[licence]" style="height: 80px; width: 550px"
                                  onFocus="this.style.borderColor='#00CC00'"
                                  onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['licence']); ?></textarea>
                    </td>
                </tr>

                </tbody>
                <tbody id="config2" style="display:none">
                <tr nowrap class="firstalt">
                    <td width="260" valign='top'><b>���������ȡ</b><br>
                        <font color="#666666">��ֻ��ɼ�ĳ�������ʱ��ʹ��<br>��֧�ֽ�ȡbody֮��<br><font color="red">һ������</font></font></td>
                    <td>��ʼ���
                        <textarea name="con[body_start]" style="height: 100px; width: 200px"
                                  onFocus="this.style.borderColor='#00CC00'"
                                  onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['body_start']); ?></textarea>&nbsp;�������
                        <textarea name="con[body_end]" style="height: 100px; width: 200px"
                                  onFocus="this.style.borderColor='#00CC00'"
                                  onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['body_end']); ?></textarea>
                    </td>
                </tr>
                <tr nowrap class="firstalt">
                    <td width="260"><b>��ǩ����</b><br>
                        <font color="#666666">�ɼ�ҳ��ʱ���˵���Щ��ǩ<br><font color="red">����</font>,���򽫿��ܳ��ֲɼ��������ʹ�λ����</font></td>
                    <td>
                        <input name="siftags[]" type="checkbox" value="iframe"
                               <?php if (in_array('iframe', $caiji_config['siftags']) || $ac == 'add'){ ?>checked<?php } ?> />
                        iframe
                        <input name="siftags[]" type="checkbox" value="object"
                               <?php if (in_array('object', $caiji_config['siftags']) || $ac == 'add'){ ?>checked<?php } ?> />
                        object
                        <input name="siftags[]" type="checkbox" value="script"
                               <?php if (in_array('script', $caiji_config['siftags'])){ ?>checked<?php } ?> /> script
                        <input name="siftags[]" type="checkbox" value="form"
                               <?php if (in_array('form', $caiji_config['siftags'])){ ?>checked<?php } ?> /> form
                        <input name="siftags[]" type="checkbox" value="input"
                               <?php if (in_array('input', $caiji_config['siftags'])){ ?>checked<?php } ?> /> input
                        <input name="siftags[]" type="checkbox" value="textarea"
                               <?php if (in_array('textarea', $caiji_config['siftags'])){ ?>checked<?php } ?> />
                        textarea
                        <input name="siftags[]" type="checkbox" value="botton"
                               <?php if (in_array('botton', $caiji_config['siftags'])){ ?>checked<?php } ?> /> botton
                        <input name="siftags[]" type="checkbox" value="select"
                               <?php if (in_array('select', $caiji_config['siftags'])){ ?>checked<?php } ?> /> select
                        <input name="siftags[]" type="checkbox" value="div"
                               <?php if (in_array('div', $caiji_config['siftags'])){ ?>checked<?php } ?> /> div
                        <input name="siftags[]" type="checkbox" value="table"
                               <?php if (in_array('table', $caiji_config['siftags'])){ ?>checked<?php } ?> /> table
                        <input name="siftags[]" type="checkbox" value="th"
                               <?php if (in_array('tr', $caiji_config['siftags'])){ ?>checked<?php } ?> /> th
                        <input name="siftags[]" type="checkbox" value="tr"
                               <?php if (in_array('tr', $caiji_config['siftags'])){ ?>checked<?php } ?> /> tr
                        <input name="siftags[]" type="checkbox" value="td"
                               <?php if (in_array('td', $caiji_config['siftags'])){ ?>checked<?php } ?> /> td
                        <input name="siftags[]" type="checkbox" value="span"
                               <?php if (in_array('span', $caiji_config['siftags'])){ ?>checked<?php } ?> /> span
                        <input name="siftags[]" type="checkbox" value="img"
                               <?php if (in_array('img', $caiji_config['siftags'])){ ?>checked<?php } ?> /> img
                        <input name="siftags[]" type="checkbox" value="font"
                               <?php if (in_array('font', $caiji_config['siftags'])){ ?>checked<?php } ?> /> font
                        <input name="siftags[]" type="checkbox" value="a"
                               <?php if (in_array('a', $caiji_config['siftags'])){ ?>checked<?php } ?> /> a
                        <input name="siftags[]" type="checkbox" value="html"
                               <?php if (in_array('html', $caiji_config['siftags'])){ ?>checked<?php } ?> /> html
                        <input name="siftags[]" type="checkbox" value="style"
                               <?php if (in_array('style', $caiji_config['siftags'])){ ?>checked<?php } ?> /> style
                    </td>
                </tr>
                <tr nowrap class="firstalt">
                    <td width="260"><b>վ�������</b><br>
                        <font color="#666666">�ɹ���վ�ڻ�վ�ⲻ��Ҫ�����ӻ��ļ�</font>
                    <td>
                        <input name="siftags[]" type="checkbox" value="outa"
                               <?php if (in_array('outa', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="red">վ��</font>����
                        <input name="siftags[]" type="checkbox" value="outjs"
                               <?php if (in_array('outjs', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="red">վ��</font>js�ļ�
                        <input name="siftags[]" type="checkbox" value="outcss"
                               <?php if (in_array('outcss', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="red">վ��</font>css�ļ�
                        <input name="siftags[]" type="checkbox" value="locala"
                               <?php if (in_array('locala', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="blue">վ��</font>����
                        <input name="siftags[]" type="checkbox" value="localjs"
                               <?php if (in_array('localjs', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="blue">վ��</font>js�ļ�
                        <input name="siftags[]" type="checkbox" value="localcss"
                               <?php if (in_array('localcss', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="blue">վ��</font>css�ļ�
                    </td>
                </tr>
                <tr class="firstalt">
                    <td width="260" valign='top' style="background:#fafafa"><b>�ַ����滻����</b><br>
                        <font color="#666666">�滻ǰ���滻��ֱ����<font color="red">******</font>�ָ�<br>ÿһ���滻������������ַ��ָ�����<br><font
                                    color="red">##########</font><br>���ӣ�<br>
                            <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>�����滻ǰ<font
                                        color="red">******</font>�����滻��<br><font color="red">##########</font><br>�ٶ�<font
                                        color="red">******</font>{web_name}
                        </font><br><font color="red">##########</font>
    </div>
    <div style="margin:8px 0;padding:5px 0;border-top:1px solid #eee;">
        <b>��ǩ˵����</b><br>
        {web_name} -> ��վ����<br>
        {web_url} -> ��վ��ַ<br>
        {web_domain} -> ��ǰ����<br>
        {web_thisurl} -> ��ǰҳ��url<br>
        {web_remark} -> α��̬��ʾ��<br>
        {ad.����ʶ} -> ����ǩ<br>
        {zdy.��ǩ} -> �Զ����ǩ<br>
    </div>
    <div style="margin:8px 0;padding:5px 0;border-top:1px solid #eee;">
        <b>ҳ�����֣�</b><br>
        ���滻����ͷ��<br><font color="red">index@@</font>��ʾֻ�滻��ҳ<br><font color="red">other@@</font>��ʾֻ�滻��ҳ
    </div>
    </font>
    </td>
<?php if ($ac == 'add' && $caiji_config['replacerules'] == '') {
    $caiji_config['replacerules'] = '/----------------�����滻�����и�ʽΪע��,�����ڷ���鿴,��ͬ��----------------/
##########
�������д�滻����
##########
/----------------ͼƬ�滻----------------/
##########
�������д�滻����
##########
/----------------����滻----------------/
##########
�������д�滻����
##########
/----------------�����滻----------------/
##########
�������д�滻����
##########';
} ?>
    <td><textarea name="con[replacerules]" style="height: 450px; width: 750px"
                  onFocus="this.style.borderColor='#00CC00'"
                  onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['replacerules']); ?></textarea>
    </td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260" valign='top'><b>�����滻����</b><br>
            <font color="#666666">�����滻���ʽ��һ��һ������ʽ���£�<br>
                <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>
                    <font color="red">{vivi replace='</font>�滻��<font color="red">'}</font>������ʽ<font
                            color="red">{/vivi}</font><br>
                    <font color="blue">�滻���纬�е�������ʹ��[d]�����磺</font><br>
                    <font color="red">{vivi replace='</font>[d]�滻��[d]<font color="red">'}</font>����<font color="red">{/vivi}</font>
                </div>
                <div style="margin:8px 0;padding:5px 0;border-top:1px solid #eee;">
                    <b>��ǩ˵����</b><br>ͬ��
                </div>
            </font></td>
        <td><textarea name="con[siftrules]" style="height: 250px; width: 750px"
                      onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['siftrules']); ?></textarea>
        </td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>����ǰ���滻</b><br>
            <font color="#666666">�滻�ʼ�Ĵ��루��Ŀ��վ��ԭʼhtml��<br><font color="red">������;��һ�㲻�ÿ���</font></font></td>
        <td>
            <label><input type="radio" id="replace_before_on" name="con[replace_before_on]"
                          value="1" <?php if ($caiji_config['replace_before_on']) echo " checked"; ?> />����</label>
            <label><input type="radio" id="replace_before_off" name="con[replace_before_on]"
                          value="0" <?php if (!$caiji_config['replace_before_on']) echo " checked"; ?> />�ر�</label>
        </td>
    </tr>
    <tr class="firstalt replace_before_body"<?php if (!$caiji_config['replace_before_on']) echo " style='display:none'"; ?>>
        <td width="260" valign='top'><b>ǰ���ַ����滻����</b><br>
            <font color="#666666">ʹ�÷���ͬ������滻����һ��</font>
        </td>
        <td><textarea name="con[replacerules_before]" style="height: 150px; width: 750px"
                      onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['replacerules_before']); ?></textarea>
        </td>
    </tr>
    <tr nowrap
        class="firstalt replace_before_body"<?php if (!$caiji_config['replace_before_on']) echo " style='display:none'"; ?>>
        <td width="260" valign='top'><b>ǰ�������滻����</b><br>
            <font color="#666666"><font color="#666666">ʹ�÷���ͬ����������滻����һ��</font></td>
        <td><textarea name="con[siftrules_before]" style="height: 150px; width: 750px"
                      onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['siftrules_before']); ?></textarea>
        </td>
    </tr>
    </tbody>
    <script>
        $(function () {
            $("#replace_before_on").click(function () {
                $(".replace_before_body").show();
            });
            $("#replace_before_off").click(function () {
                $(".replace_before_body").hide();
            });
        });
    </script>
    <style type="text/css">
        #quick td {
            border-bottom: 1px solid #eee;
        }
    </style>
    <tbody id="config3" style="display:none">
    <tr nowrap class="firstalt">
        <td colspan="2" align="left">
            1. ���õı�ǩ����ģ���е��ã�Ҳ�����滻������ʹ��<br>
            2. <font color="red">��ǩ�ı�ʶ�����ظ�������</font><font color="blue">ģ����ʹ��$zdy����������е��ã��磺$zdy['��ʶ']</font><br>
            3. <font color="green">�����ȡֻ��ȡ��һ��ƥ�����ݣ���ʽ�磺&lt;title&gt;(.*)&lt;/title&gt;</font><br>
            4. <font color="red">ע����û��ģ�壬�˴���������</font><br>
        </td>
    </tr>
    <tr class="firstalt">
        <td colspan="2" align="left">
            <table cellpadding="3" cellspacing="1" id="quick">
                <tr class="firstalt">
                    <td width="30" class="title_bg" align="center">���</td>
                    <td width="100" class="title_bg" align="center">��ǩ����(����)</td>
                    <td width="100" align='center'>��ʶ(Ӣ����ĸ)</td>
                    <td width="100" align='center'>����</td>
                    <td align='center'>����</td>
                    <td width="50" align="center">
                        <button type="button" class="add">����</button>
                    </td>
                    <td align='center'>&nbsp;</td>
                </tr>
                <?php if (empty($caiji_config['zdy'])) {
                    $caiji_config['zdy'] = array(array('name' => '', 'ename' => '', 'body' => '',),);
                }
                foreach ($caiji_config['zdy'] as $k => $vo) { ?>
                    <tr class="firstalt item<?php echo $k; ?>" itemid="<?php echo $k; ?>">
                        <td align="center"><?php echo $k + 1; ?></td>
                        <td align="center"><input type="text" name="zdy[<?php echo $k; ?>][name]" style="width:100px"
                                                  class="input" value="<?php echo _htmlspecialchars($vo['name']); ?>">
                        </td>
                        <td align='center'><input type="text" name="zdy[<?php echo $k; ?>][ename]" style="width:70px"
                                                  class="input" value="<?php echo _htmlspecialchars($vo['ename']); ?>">
                        </td>

                        <td align='center'><select name="zdy[<?php echo $k; ?>][type]" onchange="zdytype(this);">
                                <option value="0"<?php if ($vo['type'] == '0') echo " selected"; ?>>�Զ�������</option>
                                <option value="1"<?php if ($vo['type'] == '1') echo " selected"; ?>>��ͨ��ȡ</option>
                                <option value="2"<?php if ($vo['type'] == '2') echo " selected"; ?>>�����ȡ</option>
                            </select></td>

                        <td align="center">

                            <div class="zdy_body_<?php echo $k; ?>"<?php if ($vo['type']) echo ' style="display:none"'; ?>>
                                <textarea name="zdy[<?php echo $k; ?>][body]" style="height: 100px; width: 450px"
                                          onFocus="this.style.borderColor='#00CC00'"
                                          onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($vo['body']); ?></textarea>
                            </div>

                            <div class="zdy_regx_<?php echo $k; ?>"<?php if ($vo['type'] != 2) echo ' style="display:none"'; ?>>
                                <textarea name="zdy[<?php echo $k; ?>][regx]" style="height: 100px; width: 450px"
                                          onFocus="this.style.borderColor='#00CC00'"
                                          onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($vo['regx']); ?></textarea>
                            </div>

                            <div class="zdy_replace_<?php echo $k; ?>"<?php if ($vo['type'] != 1) echo ' style="display:none"'; ?>>
                                ��ʼ��� <textarea name="zdy[<?php echo $k; ?>][start]" style="height: 100px; width: 200px"
                                               onFocus="this.style.borderColor='#00CC00'"
                                               onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($vo['start']); ?></textarea>
                                &nbsp;�������
                                <textarea name="zdy[<?php echo $k; ?>][end]" style="height: 100px; width: 200px"
                                          onFocus="this.style.borderColor='#00CC00'"
                                          onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($vo['end']); ?></textarea>
                            </div>
                        </td>
                        <td align='center'><a href="javascript:" onclick="deltr(this);">ɾ��</a></td>
                        <td>&nbsp;</td>
                    </tr>
                <?php } ?>
            </table>
            <script type="text/javascript">
                function deltr(elem) {
                    var itemid = $(elem).parents('tr').attr('itemid');
                    $(elem).parents(".item" + itemid).remove();
                }

                function zdytype(_this) {
                    var itemid = $(_this).parents('tr').attr('itemid');
                    var id = _this.value;
                    $('.zdy_body_' + itemid).hide();
                    $('.zdy_regx_' + itemid).hide();
                    $('.zdy_replace_' + itemid).hide();
                    if (id == '0') {
                        $('.zdy_body_' + itemid).fadeIn();
                    } else if (id == '1') {
                        $('.zdy_replace_' + itemid).fadeIn();
                    } else if (id == '2') {
                        $('.zdy_regx_' + itemid).fadeIn();
                    }
                }

                $(document).ready(function () {
                    $("#quick .add").click(function () {
                        var id = $("#quick tr").prevAll("tr").length + 1;
                        var input = '<tr class="firstalt item' + id + '" itemid="' + id + '">';
                        input += '<td align="center">' + id + '</td>';
                        input += '<td align="center"><input type="text" name="zdy[' + id + '][name]" style="width:100px" class="input"></td>';
                        input += '<td align="center"><input type="text" name="zdy[' + id + '][ename]" style="width:70px" class="input"></td>';
                        input += '<td align="center"><select name="zdy[' + id + '][type]" onchange="zdytype(this);"><option value="0">�Զ�������</option><option value="1">��ͨ��ȡ</option><option value="2">�����ȡ</option></select></td>';
                        input += '<td align="center"><div class="zdy_body_' + id + '"><textarea name="zdy[' + id + '][body]" style="height: 100px; width: 450px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea></div><div class="zdy_regx_' + id + '" style="display:none"><textarea name="zdy[' + id + '][regx]" style="height: 100px; width: 450px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea></div><div style="display:none" class="zdy_replace_' + id + '">��ʼ��� <textarea name="zdy[' + id + '][start]" style="height: 100px; width: 200px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea>&nbsp;�������<textarea name="zdy[' + id + '][end]" style="height: 100px; width: 200px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea></div></td>';
                        input += '<td align="center"><a href="javascript:" onclick="deltr(this);">ɾ��</a></td>';
                        input += '<td>&nbsp;</td></tr>';
                        $("#quick").append(input);
                    });
                    $("#form").submit(function (e) {
                        $('.firstalt input[type="submit"]').attr('disabled', 'disabled').val(' ���ڱ���... ');
                        $.ajax({
                            type: "post",
                            url: "?ac=save&id=<?php echo $id ?>",
                            data: $("#form").serialize(),
                            timeout: 20000,
                            dataType: 'json',
                            global: false,
                            success: function (data) {
                                alert(data.info);
                                $('.firstalt input[type="submit"]').attr('disabled', false).val(' �ύ ');
                            }
                        });
                        return false;
                    });
                });
            </script>
        </td>
    </tr>
    </tbody>
    <tbody id="config4" style="display:none">
    <tr nowrap class="firstalt">
        <td width="260" valign='top'><b>�Զ���css</b><br>
            <font color="#666666">css���룬һ��һ������ʽ���£�<br>
                <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'><font
                            color="red">.a{color:red}</font></div>
                ��ʾ��{webpath}��ʾ��·��</font></td>
        <td><textarea name="con[css]" style="height: 100px; width: 550px" onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['css']); ?></textarea>
        </td>
    </tr>
    </tbody>
    <tbody id="config5" style="display:none">
    <tr nowrap class="firstalt">
        <td width="260"><b>����ת</b> <br>
            <font color="#666666">�����������֮�以ת��Ӱ���ٶ�</font></td>
        <td><select name="con[big52gbk]">
                <option value="togbk" <?php if ($caiji_config['big52gbk'] == 'togbk') echo " selected"; ?>>��ת��</option>
                <option value="tobig5" <?php if ($caiji_config['big52gbk'] == 'tobig5') echo " selected"; ?>>��ת��
                </option>
                <option value="0" <?php if (!$caiji_config['big52gbk']) echo " selected"; ?>>�ر�</option>
            </select></td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>αԭ������</b><br>
            <font color="#666666">����αԭ��</font></td>
        <td><select name="con[replace]">
                <option value="1" <?php if ($caiji_config['replace']) echo " selected"; ?>>����</option>
                <option value="0" <?php if (!$caiji_config['replace']) echo " selected"; ?>>�ر�</option>
            </select></td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>α��̬����</b> <br>
            <font color="red">��Ҫ�ռ�/������֧��α��̬</font></td>
        <td><select name="con[rewrite]">
                <option value="1" <?php if ($caiji_config['rewrite']) echo " selected"; ?>>����</option>
                <option value="0" <?php if (!$caiji_config['rewrite']) echo " selected"; ?>>�ر�</option>
            </select></td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>ģ���ļ���</b><br>
            <font color="#666666">��ģ���ϴ���template�ļ�����<br>Ȼ����д���ļ�����<font color="red">һ������</font></font></td>
        <td><input type="text" name="con[tplfile]" id="tplfile" size="10"
                   value="<?php echo $caiji_config['tplfile']; ?>" onFocus="this.style.borderColor='#00CC00'"
                   onBlur="this.style.borderColor='#dcdcdc'"> ������Ĭ��Ϊindex.html
        </td>
    </tr>
    <?php $plusArr = array();
    if ($caiji_config['plus']) {
        $plusArr = explode(',', $caiji_config['plus']);
    }
    if (is_dir(VV_DATA . '/plus')) {
        $arr = scandirs(VV_DATA . '/plus');
        unset($arr[0], $arr[1]);
    } ?>
    <style type="text/css">
        .custom-header {
            text-align: center;
            padding: 3px;
            background: #000;
            color: #fff;
        }
    </style>
    <tr nowrap class="firstalt">
        <td width="260"><b>ʹ�ò��</b><br>
            <font color="#666666">���λ��/data/plus/�ļ���<br>��д������ʾ��</td>
        <td><select name="con[plus][]" multiple='multiple' class="selectmultiple">
                <?php if ($arr) {
                    define('VV_PLUS', true);
                    $dir = VV_DATA . '/plus';
                    foreach ($arr as $k => $vo) {
                        $plusfile = $dir . '/' . $vo . '/' . $vo . '.class.php';
                        if (!is_dir($dir . '/' . $vo) || !is_file($plusfile)) {
                            continue;
                        }
                        require_once($plusfile);
                        $plusclass = new $vo;
                        $plusinfo = $plusclass->info; ?>
                        <option value="<?php echo $vo; ?>" <?php if (in_array($vo, $plusArr)) echo " selected"; ?>><?php echo $plusinfo['name']; ?></option>
                    <?php }
                } ?>
            </select>
            <script type="text/javascript">$('.selectmultiple').multiSelect({
                    keepOrder: true,
                    selectableHeader: "<div class='custom-header'>δʹ�õĲ��</div>",
                    selectionHeader: "<div class='custom-header'>����ʹ�õĲ��</div>"
                });</script>
        </td>
    </tr>
    </tbody>
    <tbody id="config6" style="display:none">
    <tr nowrap class="firstalt">
        <td width="260"><b>�Զ���cookie</b><br>
            <font color="#666666">ʹ�ø�cookie����Ŀ��վ<br>һ��������Ҫ��½���ܲɼ���վ��</font></td>
        <td><textarea name="con[cookie]" style="height: 100px; width: 550px" onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['cookie']); ?></textarea>
        </td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>�Զ����������ʶ��user-agent��</b><br>
            <font color="#666666">��α���������α��֩������</font></td>
        <td><input type="text" name="con[user_agent]" id="user_agent" style="width:300px;"
                   value="<?php echo $caiji_config['user_agent']; ?>" onFocus="this.style.borderColor='#00CC00'"
                   onBlur="this.style.borderColor='#dcdcdc'">&nbsp;<select onchange="$('#user_agent').val(this.value);">
                <option value="">�Զ���</option>
                <option value="Baiduspider/2.0+(+http://www.baidu.com/search/spider.htm)" <?php if ($caiji_config['user_agent'] == 'Baiduspider/2.0+(+http://www.baidu.com/search/spider.htm)') echo " selected"; ?>>
                    ģ��ٶ�֩��
                </option>
                <option value="Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)" <?php if ($caiji_config['user_agent'] == 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)') echo " selected"; ?>>
                    ģ��ȸ�֩��
                </option>
            </select></td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>�Զ�����·</b><br>
            <font color="#666666">α����·������д���Զ�α��ΪĿ��վurl</font></td>
        <td><input type="text" name="con[referer]" style="width:300px;" value="<?php echo $caiji_config['referer']; ?>"
                   onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'"></td>
    </tr>

    <tr nowrap class="firstalt">
        <td width="260"><b>�Զ���IP</b><br>
            <font color="#666666">�Զ���IP��ʽ 127.0.0.1<br>����IP�ĸ�ʽ 127.0.0.1:8080@user:pass
                <br><br>
                <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>
                    <font color="black">���ж������IP���ɱ���Ϊtxt�ļ��ϴ���Ŀ¼</font><br>
                    <font color="blue">ѡ����IP����дtxt·���磺/data/daili.txt<br>
                        txtÿ��һ��������ʽ���£�<br></font>
                    <font color="red">127.0.0.1:8081</font><br>
                    <font color="red">127.0.0.1:8080@user:pass</font><br>...
                </div>
                <br>
                <?php if (function_exists('curl_init') && function_exists('curl_exec')) {
                    echo '<font color="green">��Ŀռ�֧��curl��֧�ִ���IP����</font>';
                } else {
                    echo '<font color="red">��Ŀռ䲻֧��curl������ʹ�ô���IP����</font>';
                } ?>


            </font>
        </td>
        <td><input type="text" name="con[ip]" style="width:300px;" value="<?php echo $caiji_config['ip']; ?>"
                   onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">&nbsp;<select
                    name="con[ip_type]">
                <option value="1"<?php if ($caiji_config['ip_type'] == 1) echo " selected"; ?>>�Զ���IP</option>
                <option value="2"<?php if ($caiji_config['ip_type'] == 2) echo " selected"; ?>>���IP</option>
                <option value="3"<?php if ($caiji_config['ip_type'] == 3) echo " selected"; ?>>����IP</option>
            </select></td>
    </tr>
    </tbody>
    <tbody>
    <tr class="firstalt">
        <td align="center" colspan="2">
            <input type="submit" value=" �ύ " name="submit" class="bginput">&nbsp;&nbsp;<input type="button"
                                                                                               onclick="history.go(-1);"
                                                                                               value=" ���� " name="Input"
                                                                                               class="bginput"></td>
    </tr>
    </tbody>
    </table>
    </form>
    <?php } ?>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</htm>