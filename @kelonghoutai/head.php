<?php ?>
<!doctype html>
<html class="no-js">
<head>
    <meta charset="gbk">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Winbo��̨</title>
    <meta name="description" content="����һ�� user ҳ��">
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
        <strong>Winbo</strong> <small>��̨����</small>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">�����л�</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li><a href="javascript:;"><span class="am-icon-plus-square-o"></span> ������վ <span class="am-badge am-badge-secondary">�ٶ�</span></a></li>
            <li><a href="javascript:;"><span class="am-icon-plus-square-o"></span> ������վ <span class="am-badge am-badge-success">360</span></a></li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li><a href="/"><span class="am-icon-home"></span> ��ҳ</a></li>

                <li><a href="admin.php"><span class="am-icon-wrench"></span> ��������</a></li>
                <li><a href="tihuan.php"><span class="am-icon-pencil-square-o"></span> �滻</a></li>
                <li><a href="url_replace.php"><span class="am-icon-rss"></span> url��������</a>
                <li><a href="seo_setting.php"><span class="am-icon-google-plus"> seo����</span></a></li>
                <li><a href="cachetime.php"><span class="am-icon-cloud-download"></span> ��������</a></li>
                <li><a href="#"><span class="am-icon-trash-o"></span> �������</a></li>

                <li><a href="#"><span class="am-icon-sign-out"></span> ��������</a></li>
            </ul>

            <div class="am-panel am-panel-default admin-sidebar-panel">
                <div class="am-panel-bd">
                    <p><span class="am-icon-bookmark"></span> ����</p>
                    <p>����˼�䣬����˼��!</p>
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