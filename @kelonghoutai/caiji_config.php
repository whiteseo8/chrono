<?php require_once("data.php");
$v_config = require_once("../data/config.php");
require_once("checkAdmin.php");
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
$ac = isset($_GET['ac']) ? $_GET['ac'] : '';
if ($ac == 'del') {
    $file = VV_DATA . '/config/' . $id . '.php';
    if (@unlink($file)) ShowMsg("恭喜你,删除成功！", 'caiji_config.php', 500);
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
    ShowMsg("恭喜你,修改成功！", 'caiji_config.php', 500);
}
if ($ac == 'status') {
    $collectid = (int)$_GET['collectid'];
    $file = VV_DATA . '/config/' . $collectid . '.php';
    $sid = intval($_GET['sid']);
    if (!is_file($file)) ShowMsg("采集配置文件不存在", '-1', 2000);
    $caiji_config = require_once($file);
    if ($caiji_config) {
        $caiji_config['collect_close'] = $sid;
        arr2file($file, $caiji_config);
    }
    ShowMsg("恭喜你,修改成功！", '?', 500);
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
                ajaxReturn(array('status' => 0, 'info' => "过滤规则的正则表达式格式不正确"));
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
                ajaxReturn(array('status' => 0, 'info' => "过滤规则的正则表达式格式不正确"));
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
        ajaxReturn(array('status' => 1, 'info' => "修改失败，检查文件写入权限！"));
    }
    ajaxReturn(array('status' => 1, 'info' => "恭喜你,修改成功！"));
}
if ($ac == 'saveimport') {
    $text = trim($_POST['import_text']);
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if (!$id) {
        $arr = glob(VV_DATA . '/config/*.php');
        if (!OoO0o0O0o() && count($arr) >= 2) ShowMsg('导入失败，未授权只能有2条规则', '-1', 6000);
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
            ShowMsg('该规则不合法，采集规则为：VIVI:base64代码:END !', '-1', 6000);
        }
        $notess = explode(':', $text);
        $config = $notess[1];
        $config = unserialize(base64_decode(preg_replace("#[\r\n\t ]#", '', $config))) OR die('配置字符串有错误！');
    } else {
        ShowMsg("该规则不合法，无法导入！", '-1', 6000);
    }
    arr2file($file, $config);
    ShowMsg("恭喜你,导入成功！", 'caiji_config.php', 2000);
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
                    <td colspan="8">采集节点管理&nbsp;&nbsp;-&nbsp;<a href="?ac=add" style='color:red'>添加</a>&nbsp;-&nbsp;<a
                                href="?ac=import" style='color:red'>导入</a>&nbsp;-&nbsp;<a href="http://www.vxiaotou.com"
                                                                                          target="_blank"
                                                                                          style='color:red'>获取更多规则</a>
                    </td>
                </tr>
                </tbody>
                <tr nowrap class="firstalt">
                    <td colspan="8"><font color="#dd00b0">注：采集开关为关闭时，将停止采集仅使用缓存！</font></td>
                </tr>
                <?php if (!OoO0o0O0o()) { ?>
                    <tr nowrap class="firstalt">
                        <td colspan="8" align="center"><font color="blue">未授权只能有2条规则</font></td>
                    </tr>
                <?php } ?>
                <tr nowrap class="firstalt">
                    <td width="60" align="center">默认</td>
                    <td width="50" align="center">ID</td>
                    <td align="center">节点名称</td>
                    <td width="70" align="center">采集开关</td>
                    <td width="70" align="center">说明(点击↓↓)</td>
                    <td width="100" align="center">编码</td>
                    <td width="130" align="center">修改时间</td>
                    <td width="250" align="center">操作</td>
                </tr>
                <?php if ($temp) {
                    foreach ($temp as $k => $vo) { ?>
                        <tr nowrap class="firstalt">
                            <td width="60"
                                align="center"><?php echo $vo['id'] == $v_config['collectid'] ? '<font color="red">默认节点</font>' : '<a href="?ac=savecollectid&collectid=' . $vo['id'] . '&sid=0" title="点击设为默认节点">设为默认</a>'; ?></td>
                            <td width="50" align="center"><?php echo $vo['id'] ?></td>
                            <td style="padding-left:20px"><a
                                        href="?ac=xiugai&id=<?php echo $vo['id'] ?>"><?php echo $vo['name'] ?></a></td>
                            <td align="center"><?php echo $vo['collect_close'] ? '<a href="?ac=status&collectid=' . $vo['id'] . '&sid=0" title="点击开启"><font color="red">已关闭</font></a>' : '<a href="?ac=status&collectid=' . $vo['id'] . '&sid=1" title="点击关闭"><font color="green">已开启</font></a>'; ?></td>
                            <td width="100" align="center"><a href="javascript:"
                                                              onclick='alert("<?php echo !empty($vo['licence']) ? str_replace(array("\r\n", "\r", "\n"), '\\n', $vo['licence']) : '无'; ?>");'>点我</a>
                            </td>
                            <td width="100" align="center"><?php echo $vo['charset'] ?></td>
                            <td width="150" align="center"><?php echo date('Y-m-d H:i:s', $vo['time']) ?></td>
                            <td width="200" align="center"><a target="_blank"
                                                              href="?ac=yulan&collectid=<?php echo $vo['id'] ?>">预览源代码</a>&nbsp;&nbsp;<a
                                        href="?ac=xiugai&id=<?php echo $vo['id'] ?>">修改</a>&nbsp;&nbsp;<a
                                        href="?ac=export&id=<?php echo $vo['id'] ?>">导出</a>&nbsp;&nbsp;<a
                                        href="?ac=import&id=<?php echo $vo['id'] ?>">导入</a>&nbsp;&nbsp;<a
                                        href="?ac=del&id=<?php echo $vo['id'] ?>"
                                        onClick="return confirm('确定删除?')">删除</a></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr nowrap class="firstalt">
                        <td colspan="8" align="center">没有找到采集节点！</td>
                    </tr>
                <?php } ?>

            </table>
        <?php } elseif ($ac == 'export') {
            $file = VV_DATA . '/config/' . $id . '.php';
            if (!is_file($file)) ShowMsg("采集配置文件不存在", '-1', 2000);
            $caiji_config = require_once($file);
            $basecon = "VIVI:" . base64_encode(serialize($caiji_config)) . ":END"; ?>
            <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
                <tbody>
                <tr nowrap class="tb_head">
                    <td><h2>导出采集规则</h2></td>
                </tr>
                </tbody>
                <tr nowrap class="firstalt">
                    <td><b>以下为规则 [<?php echo $caiji_config['name']; ?>] 的配置，你可以共享给你的朋友:</b></td>
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
                if (!is_file($file)) ShowMsg("采集配置文件不存在", '-1', 3000);
                $caiji_config = require_once($file);
                $tinfo = '( 覆盖[' . $caiji_config['name'] . ']？)<input type="hidden" name="id" value="' . $id . '" />';
            } ?>
            <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">
                <form action="?ac=saveimport" method="post">
                    <tbody>
                    <tr nowrap class="tb_head">
                        <td><h2>导入采集规则</h2></td>
                    </tr>
                    </tbody>
                    <tr nowrap class="firstalt">
                        <td><b>请在下面输入你要导入的采集配置</b><font color="red"><?php echo $tinfo ?></font>：</td>
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
                            <input type="submit" value=" 提交 " name="submit" class="bginput">&nbsp;&nbsp;<input
                                    type="button" onclick="history.go(-1);" value=" 返回 " name="Input" class="bginput">
                        </td>
                    </tr>
                    </tbody>
                </form>
            </table>
        <?php }
        elseif ($ac == 'xiugai' || $ac == 'add'){
        if ($ac == 'xiugai') {
            $file = VV_DATA . '/config/' . $id . '.php';
            if (!is_file($file)) ShowMsg("采集配置文件不存在", '-1', 3000);
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
                        <div style='float:left;padding:5px;'>采集节点设置：</div>&nbsp;&nbsp;<div
                                style='float:left;padding:5px;border:1px dotted #ff6600;background:#ffffee'>
                            过滤替换规则是在程序处理之后执行，请按照采集后的页面源代码进行编写，不是目标站原始源代码，保存后打开<font color="red">本站前台</font>页面查看源代码
                        </div>
                    </td>
                </tr>
                <tr class="firstalt">
                    <td colspan="2">
                        <ul class="do_nav">
                            <li id="tab1" class="cur"><a onclick="tab(1,6);" href="javascript:">基本设置</a></li>
                            <li id="tab2"><a onclick="tab(2,6);" href="javascript:">替换过滤</a></li>
                            <li id="tab3"><a onclick="tab(3,6);" href="javascript:">自定义标签</a></li>
                            <li id="tab4"><a onclick="tab(4,6);" href="javascript:">自定义css</a></li>
                            <li id="tab5"><a onclick="tab(5,6);" href="javascript:">高级功能</a><img
                                        src="../public/img/vip.gif" style="cursor: pointer;vertical-align: middle;"
                                        title="vip功能" width="19" height="18"/></li>
                            <li id="tab6"><a onclick="tab(6,6);" href="javascript:">破防采集</a><img
                                        src="../public/img/vip.gif" style="cursor: pointer;vertical-align: middle;"
                                        title="vip功能" width="19" height="18"/></li>
                        </ul>
                    </td>
                </tr>
                </tbody>
                <tbody id="config1">
                <tr nowrap class="firstalt">
                    <td width="260"><b>节点名称</b><br>
                        <font color="#666666">给你的采集起一个名字</font></td>
                    <td><input type="text" name="con[name]" size="50" value="<?php echo $caiji_config['name']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>目标网站名称</b><br>
                        <font color="#666666">多个用符号 * 分隔</font><br><font color="red">注：不要只填写字母或者域名，否则替换出错</font></td>
                    <td><input type="text" name="con[from_title]" id="from_title" size="50"
                               value="<?php echo $caiji_config['from_title']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>目标站地址</b><br>
                        <font color="#666666">需要采集的目标网站地址</font><br><font color="red">注：http://或https://开头</font></td>
                    <td><input type="text" name="con[from_url]" id="from_url" size="50"
                               value="<?php echo $caiji_config['from_url']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">&nbsp;<select
                                name="con[charset]">
                            <option value="auto" <?php if ($caiji_config['charset'] == 'auto' || empty($caiji_config['charset'])) echo " selected"; ?>>
                                自动识别
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
                        </select>&nbsp;目标站编码
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>其他域名</b><br>
                        <font color="#666666">目标站多个域名绑定一个站点时填写<br>每个域名用半角逗号分隔<br>
                            <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>如: baidu.com<font
                                        color="red">,</font>www.baidu.com
                            </div>
                        </font></td>
                    <td><input type="text" name="con[other_url]" id="other_url" size="50"
                               value="<?php echo $caiji_config['other_url']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>目标站资源域名</b><br>
                        <font color="#666666">可填写需要采集的css图片等资源域名<br>每个域名用半角逗号分隔<br>
                            <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>如: img1.baidu.com<font
                                        color="red">,</font>*.baidu.com
                            </div>
                        </font></td>
                    <td><input type="text" name="con[resdomain]" id="resdomain" size="50"
                               value="<?php echo $caiji_config['resdomain']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>图片属性名称</b><br>
                        <font color="#666666">当目标站图片使用延迟加载的时候使用<br>每个用半角逗号分隔<br>
                            <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>如: data-src<font
                                        color="red">,</font>_src
                            </div>
                        </font></td>
                    <td><input type="text" name="con[img_delay_name]" size="50"
                               value="<?php echo $caiji_config['img_delay_name']; ?>"
                               onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">
                        <font color="red">一般不用设置</font></td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>目标站搜索地址</b><br>
                        <font color="#666666">目标站搜索地址，有域名的要带上</font></td>
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
                        </select>&nbsp;搜索页面的编码
                    </td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>屏蔽js错误</b><br>
                        <font color="#666666">是否屏蔽js错误</font></td>
                    <td><select name="con[hidejserror]">
                            <option value="0" <?php if ($caiji_config['hidejserror'] == '0') echo " selected"; ?>>关闭
                            </option>
                            <option value="1" <?php if ($caiji_config['hidejserror']) echo " selected"; ?>>开启</option>
                        </select></td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260"><b>禁止移动搜索转码</b><br>
                        <font color="#666666">此选项可禁止百度移动搜索转码</font></td>
                    <td><select name="con[no_siteapp]">
                            <option value="0" <?php if ($caiji_config['no_siteapp'] == '0') echo " selected"; ?>>关闭
                            </option>
                            <option value="1" <?php if ($caiji_config['no_siteapp']) echo " selected"; ?>>开启</option>
                        </select></td>
                </tr>

                <tr nowrap class="firstalt">
                    <td width="260" valign='top'><b>使用说明</b><br>
                        <font color="#666666">填写作者信息、使用协议或说明、注意事项</font></td>
                    <td><textarea name="con[licence]" style="height: 80px; width: 550px"
                                  onFocus="this.style.borderColor='#00CC00'"
                                  onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['licence']); ?></textarea>
                    </td>
                </tr>

                </tbody>
                <tbody id="config2" style="display:none">
                <tr nowrap class="firstalt">
                    <td width="260" valign='top'><b>主体区域截取</b><br>
                        <font color="#666666">当只想采集某个区域的时候使用<br>仅支持截取body之间<br><font color="red">一般留空</font></font></td>
                    <td>开始标记
                        <textarea name="con[body_start]" style="height: 100px; width: 200px"
                                  onFocus="this.style.borderColor='#00CC00'"
                                  onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['body_start']); ?></textarea>&nbsp;结束标记
                        <textarea name="con[body_end]" style="height: 100px; width: 200px"
                                  onFocus="this.style.borderColor='#00CC00'"
                                  onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['body_end']); ?></textarea>
                    </td>
                </tr>
                <tr nowrap class="firstalt">
                    <td width="260"><b>标签过滤</b><br>
                        <font color="#666666">采集页面时过滤掉这些标签<br><font color="red">慎用</font>,否则将可能出现采集不完整和错位现象</font></td>
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
                    <td width="260"><b>站内外过滤</b><br>
                        <font color="#666666">可过滤站内或站外不必要的链接或文件</font>
                    <td>
                        <input name="siftags[]" type="checkbox" value="outa"
                               <?php if (in_array('outa', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="red">站外</font>链接
                        <input name="siftags[]" type="checkbox" value="outjs"
                               <?php if (in_array('outjs', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="red">站外</font>js文件
                        <input name="siftags[]" type="checkbox" value="outcss"
                               <?php if (in_array('outcss', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="red">站外</font>css文件
                        <input name="siftags[]" type="checkbox" value="locala"
                               <?php if (in_array('locala', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="blue">站内</font>链接
                        <input name="siftags[]" type="checkbox" value="localjs"
                               <?php if (in_array('localjs', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="blue">站内</font>js文件
                        <input name="siftags[]" type="checkbox" value="localcss"
                               <?php if (in_array('localcss', $caiji_config['siftags'])){ ?>checked<?php } ?> /> <font
                                color="blue">站内</font>css文件
                    </td>
                </tr>
                <tr class="firstalt">
                    <td width="260" valign='top' style="background:#fafafa"><b>字符串替换规则</b><br>
                        <font color="#666666">替换前和替换后直接用<font color="red">******</font>分隔<br>每一对替换后面用下面的字符分隔开来<br><font
                                    color="red">##########</font><br>例子：<br>
                            <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>我是替换前<font
                                        color="red">******</font>我是替换后<br><font color="red">##########</font><br>百度<font
                                        color="red">******</font>{web_name}
                        </font><br><font color="red">##########</font>
    </div>
    <div style="margin:8px 0;padding:5px 0;border-top:1px solid #eee;">
        <b>标签说明：</b><br>
        {web_name} -> 网站名称<br>
        {web_url} -> 网站地址<br>
        {web_domain} -> 当前域名<br>
        {web_thisurl} -> 当前页面url<br>
        {web_remark} -> 伪静态标示符<br>
        {ad.广告标识} -> 广告标签<br>
        {zdy.标签} -> 自定义标签<br>
    </div>
    <div style="margin:8px 0;padding:5px 0;border-top:1px solid #eee;">
        <b>页面区分：</b><br>
        在替换规则开头加<br><font color="red">index@@</font>表示只替换首页<br><font color="red">other@@</font>表示只替换内页
    </div>
    </font>
    </td>
<?php if ($ac == 'add' && $caiji_config['replacerules'] == '') {
    $caiji_config['replacerules'] = '/----------------文字替换（本行格式为注释,仅用于方便查看,下同）----------------/
##########
这里可以写替换规则
##########
/----------------图片替换----------------/
##########
这里可以写替换规则
##########
/----------------广告替换----------------/
##########
这里可以写替换规则
##########
/----------------其他替换----------------/
##########
这里可以写替换规则
##########';
} ?>
    <td><textarea name="con[replacerules]" style="height: 450px; width: 750px"
                  onFocus="this.style.borderColor='#00CC00'"
                  onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['replacerules']); ?></textarea>
    </td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260" valign='top'><b>正则替换规则</b><br>
            <font color="#666666">正则替换表达式，一行一个，格式如下：<br>
                <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>
                    <font color="red">{vivi replace='</font>替换后<font color="red">'}</font>正则表达式<font
                            color="red">{/vivi}</font><br>
                    <font color="blue">替换后如含有单引号则使用[d]代替如：</font><br>
                    <font color="red">{vivi replace='</font>[d]替换后[d]<font color="red">'}</font>正则<font color="red">{/vivi}</font>
                </div>
                <div style="margin:8px 0;padding:5px 0;border-top:1px solid #eee;">
                    <b>标签说明：</b><br>同上
                </div>
            </font></td>
        <td><textarea name="con[siftrules]" style="height: 250px; width: 750px"
                      onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['siftrules']); ?></textarea>
        </td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>开启前置替换</b><br>
            <font color="#666666">替换最开始的代码（即目标站的原始html）<br><font color="red">特殊用途，一般不用开启</font></font></td>
        <td>
            <label><input type="radio" id="replace_before_on" name="con[replace_before_on]"
                          value="1" <?php if ($caiji_config['replace_before_on']) echo " checked"; ?> />开启</label>
            <label><input type="radio" id="replace_before_off" name="con[replace_before_on]"
                          value="0" <?php if (!$caiji_config['replace_before_on']) echo " checked"; ?> />关闭</label>
        </td>
    </tr>
    <tr class="firstalt replace_before_body"<?php if (!$caiji_config['replace_before_on']) echo " style='display:none'"; ?>>
        <td width="260" valign='top'><b>前置字符串替换规则</b><br>
            <font color="#666666">使用方法同上面的替换规则一致</font>
        </td>
        <td><textarea name="con[replacerules_before]" style="height: 150px; width: 750px"
                      onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['replacerules_before']); ?></textarea>
        </td>
    </tr>
    <tr nowrap
        class="firstalt replace_before_body"<?php if (!$caiji_config['replace_before_on']) echo " style='display:none'"; ?>>
        <td width="260" valign='top'><b>前置正则替换规则</b><br>
            <font color="#666666"><font color="#666666">使用方法同上面的正则替换规则一致</font></td>
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
            1. 设置的标签可在模板中调用，也可在替换规则中使用<br>
            2. <font color="red">标签的标识不可重复！！！</font><font color="blue">模板中使用$zdy数组变量进行调用，如：$zdy['标识']</font><br>
            3. <font color="green">正则截取只获取第一个匹配内容，格式如：&lt;title&gt;(.*)&lt;/title&gt;</font><br>
            4. <font color="red">注：如没有模板，此处无需设置</font><br>
        </td>
    </tr>
    <tr class="firstalt">
        <td colspan="2" align="left">
            <table cellpadding="3" cellspacing="1" id="quick">
                <tr class="firstalt">
                    <td width="30" class="title_bg" align="center">编号</td>
                    <td width="100" class="title_bg" align="center">标签名称(中文)</td>
                    <td width="100" align='center'>标识(英文字母)</td>
                    <td width="100" align='center'>类型</td>
                    <td align='center'>设置</td>
                    <td width="50" align="center">
                        <button type="button" class="add">增加</button>
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
                                <option value="0"<?php if ($vo['type'] == '0') echo " selected"; ?>>自定义内容</option>
                                <option value="1"<?php if ($vo['type'] == '1') echo " selected"; ?>>普通截取</option>
                                <option value="2"<?php if ($vo['type'] == '2') echo " selected"; ?>>正则截取</option>
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
                                开始标记 <textarea name="zdy[<?php echo $k; ?>][start]" style="height: 100px; width: 200px"
                                               onFocus="this.style.borderColor='#00CC00'"
                                               onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($vo['start']); ?></textarea>
                                &nbsp;结束标记
                                <textarea name="zdy[<?php echo $k; ?>][end]" style="height: 100px; width: 200px"
                                          onFocus="this.style.borderColor='#00CC00'"
                                          onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($vo['end']); ?></textarea>
                            </div>
                        </td>
                        <td align='center'><a href="javascript:" onclick="deltr(this);">删除</a></td>
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
                        input += '<td align="center"><select name="zdy[' + id + '][type]" onchange="zdytype(this);"><option value="0">自定义内容</option><option value="1">普通截取</option><option value="2">正则截取</option></select></td>';
                        input += '<td align="center"><div class="zdy_body_' + id + '"><textarea name="zdy[' + id + '][body]" style="height: 100px; width: 450px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea></div><div class="zdy_regx_' + id + '" style="display:none"><textarea name="zdy[' + id + '][regx]" style="height: 100px; width: 450px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea></div><div style="display:none" class="zdy_replace_' + id + '">开始标记 <textarea name="zdy[' + id + '][start]" style="height: 100px; width: 200px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea>&nbsp;结束标记<textarea name="zdy[' + id + '][end]" style="height: 100px; width: 200px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea></div></td>';
                        input += '<td align="center"><a href="javascript:" onclick="deltr(this);">删除</a></td>';
                        input += '<td>&nbsp;</td></tr>';
                        $("#quick").append(input);
                    });
                    $("#form").submit(function (e) {
                        $('.firstalt input[type="submit"]').attr('disabled', 'disabled').val(' 正在保存... ');
                        $.ajax({
                            type: "post",
                            url: "?ac=save&id=<?php echo $id ?>",
                            data: $("#form").serialize(),
                            timeout: 20000,
                            dataType: 'json',
                            global: false,
                            success: function (data) {
                                alert(data.info);
                                $('.firstalt input[type="submit"]').attr('disabled', false).val(' 提交 ');
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
        <td width="260" valign='top'><b>自定义css</b><br>
            <font color="#666666">css代码，一行一个，格式如下：<br>
                <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'><font
                            color="red">.a{color:red}</font></div>
                提示：{webpath}表示根路径</font></td>
        <td><textarea name="con[css]" style="height: 100px; width: 550px" onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['css']); ?></textarea>
        </td>
    </tr>
    </tbody>
    <tbody id="config5" style="display:none">
    <tr nowrap class="firstalt">
        <td width="260"><b>繁简互转</b> <br>
            <font color="#666666">繁体简体中文之间互转，影响速度</font></td>
        <td><select name="con[big52gbk]">
                <option value="togbk" <?php if ($caiji_config['big52gbk'] == 'togbk') echo " selected"; ?>>繁转简</option>
                <option value="tobig5" <?php if ($caiji_config['big52gbk'] == 'tobig5') echo " selected"; ?>>简转繁
                </option>
                <option value="0" <?php if (!$caiji_config['big52gbk']) echo " selected"; ?>>关闭</option>
            </select></td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>伪原创开关</b><br>
            <font color="#666666">开启伪原创</font></td>
        <td><select name="con[replace]">
                <option value="1" <?php if ($caiji_config['replace']) echo " selected"; ?>>开启</option>
                <option value="0" <?php if (!$caiji_config['replace']) echo " selected"; ?>>关闭</option>
            </select></td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>伪静态开关</b> <br>
            <font color="red">需要空间/服务器支持伪静态</font></td>
        <td><select name="con[rewrite]">
                <option value="1" <?php if ($caiji_config['rewrite']) echo " selected"; ?>>开启</option>
                <option value="0" <?php if (!$caiji_config['rewrite']) echo " selected"; ?>>关闭</option>
            </select></td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>模板文件名</b><br>
            <font color="#666666">将模板上传到template文件夹内<br>然后填写其文件名，<font color="red">一般留空</font></font></td>
        <td><input type="text" name="con[tplfile]" id="tplfile" size="10"
                   value="<?php echo $caiji_config['tplfile']; ?>" onFocus="this.style.borderColor='#00CC00'"
                   onBlur="this.style.borderColor='#dcdcdc'"> 留空则默认为index.html
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
        <td width="260"><b>使用插件</b><br>
            <font color="#666666">插件位于/data/plus/文件夹<br>编写方法看示例</td>
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
                    selectableHeader: "<div class='custom-header'>未使用的插件</div>",
                    selectionHeader: "<div class='custom-header'>正在使用的插件</div>"
                });</script>
        </td>
    </tr>
    </tbody>
    <tbody id="config6" style="display:none">
    <tr nowrap class="firstalt">
        <td width="260"><b>自定义cookie</b><br>
            <font color="#666666">使用该cookie访问目标站<br>一般用于需要登陆才能采集的站点</font></td>
        <td><textarea name="con[cookie]" style="height: 100px; width: 550px" onFocus="this.style.borderColor='#00CC00'"
                      onBlur="this.style.borderColor='#dcdcdc'"><?php echo _htmlspecialchars($caiji_config['cookie']); ?></textarea>
        </td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>自定义浏览器标识（user-agent）</b><br>
            <font color="#666666">可伪造浏览器，伪造蜘蛛爬行</font></td>
        <td><input type="text" name="con[user_agent]" id="user_agent" style="width:300px;"
                   value="<?php echo $caiji_config['user_agent']; ?>" onFocus="this.style.borderColor='#00CC00'"
                   onBlur="this.style.borderColor='#dcdcdc'">&nbsp;<select onchange="$('#user_agent').val(this.value);">
                <option value="">自定义</option>
                <option value="Baiduspider/2.0+(+http://www.baidu.com/search/spider.htm)" <?php if ($caiji_config['user_agent'] == 'Baiduspider/2.0+(+http://www.baidu.com/search/spider.htm)') echo " selected"; ?>>
                    模拟百度蜘蛛
                </option>
                <option value="Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)" <?php if ($caiji_config['user_agent'] == 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)') echo " selected"; ?>>
                    模拟谷歌蜘蛛
                </option>
            </select></td>
    </tr>
    <tr nowrap class="firstalt">
        <td width="260"><b>自定义来路</b><br>
            <font color="#666666">伪造来路，不填写则自动伪造为目标站url</font></td>
        <td><input type="text" name="con[referer]" style="width:300px;" value="<?php echo $caiji_config['referer']; ?>"
                   onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'"></td>
    </tr>

    <tr nowrap class="firstalt">
        <td width="260"><b>自定义IP</b><br>
            <font color="#666666">自定义IP格式 127.0.0.1<br>代理IP的格式 127.0.0.1:8080@user:pass
                <br><br>
                <div style='padding:5px;border:1px dotted #ff6600;background:#f6f6f6'>
                    <font color="black">如有多个代理IP，可保存为txt文件上传到目录</font><br>
                    <font color="blue">选代理IP，填写txt路径如：/data/daili.txt<br>
                        txt每行一个代理，格式如下：<br></font>
                    <font color="red">127.0.0.1:8081</font><br>
                    <font color="red">127.0.0.1:8080@user:pass</font><br>...
                </div>
                <br>
                <?php if (function_exists('curl_init') && function_exists('curl_exec')) {
                    echo '<font color="green">你的空间支持curl，支持代理IP功能</font>';
                } else {
                    echo '<font color="red">你的空间不支持curl，不能使用代理IP功能</font>';
                } ?>


            </font>
        </td>
        <td><input type="text" name="con[ip]" style="width:300px;" value="<?php echo $caiji_config['ip']; ?>"
                   onFocus="this.style.borderColor='#00CC00'" onBlur="this.style.borderColor='#dcdcdc'">&nbsp;<select
                    name="con[ip_type]">
                <option value="1"<?php if ($caiji_config['ip_type'] == 1) echo " selected"; ?>>自定义IP</option>
                <option value="2"<?php if ($caiji_config['ip_type'] == 2) echo " selected"; ?>>随机IP</option>
                <option value="3"<?php if ($caiji_config['ip_type'] == 3) echo " selected"; ?>>代理IP</option>
            </select></td>
    </tr>
    </tbody>
    <tbody>
    <tr class="firstalt">
        <td align="center" colspan="2">
            <input type="submit" value=" 提交 " name="submit" class="bginput">&nbsp;&nbsp;<input type="button"
                                                                                               onclick="history.go(-1);"
                                                                                               value=" 返回 " name="Input"
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