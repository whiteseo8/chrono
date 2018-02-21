<?php ?>
<!doctype html>
<html class="no-js">
<head>
    <meta charset="gbk">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Winbo后台</title>
    <meta name="description" content="这是一个 user 页面">
    <meta name="keywords" content="user">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="/public/assets/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="/public/assets/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="/public/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/public/assets/css/admin.css">
    <script src="/public/js/jquery-1.3.2.min.js"></script>
</head>
<body>

<script type="text/javascript">
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <strong>Winbo</strong> <small>后台管理</small>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li><a href="javascript:;"><span class="am-icon-plus-square-o"></span> 创建网站 <span class="am-badge am-badge-secondary">百度</span></a></li>
            <li><a href="javascript:;"><span class="am-icon-plus-square-o"></span> 创建网站 <span class="am-badge am-badge-success">360</span></a></li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li><a href="/"><span class="am-icon-home"></span> 首页</a></li>

                <li><a href="admin.php"><span class="am-icon-wrench"></span> 基本设置</a></li>
                <li><a href="tihuan.php"><span class="am-icon-pencil-square-o"></span> 替换</a></li>
                <li><a href="url_replace.php"><span class="am-icon-rss"></span> url规则设置</a>
                <li><a href="seo_setting.php"><span class="am-icon-google-plus"> seo设置</span></a></li>
                <li><a href="cachetime.php"><span class="am-icon-cloud-download"></span> 缓存设置</a></li>
                <li><a href="#"><span class="am-icon-trash-o"></span> 清除缓存</a></li>

                <li><a href="#"><span class="am-icon-sign-out"></span> 在线升级</a></li>
            </ul>

            <div class="am-panel am-panel-default admin-sidebar-panel">
                <div class="am-panel-bd">
                    <p><span class="am-icon-bookmark"></span> 公告</p>
                    <p>穷则思变，差则思勤!</p>
                </div>
            </div>

            <div class="am-panel am-panel-default admin-sidebar-panel">
                <div class="am-panel-bd">
                    <p><span class="am-icon-tag"></span> wiki</p>
                    <p>Welcome to Winbo!</p>
                </div>
            </div>
        </div>
    </div>