<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="gbk">
    <title>WinBo | 后台登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="alternate icon" type="image/png" href="/public/assets/i/favicon.png">
    <link rel="stylesheet" href="/public/assets/css/amazeui.min.css"/>
    <style>
        .header {
            text-align: center;
        }
        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }
        .header p {
            font-size: 14px;
        }
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px white inset;
            border: 1px solid #CCC!important;
        }

    </style>
</head>
<body>
<div class="header">
    <div class="am-g">
        <h1>WinBo</h1>
        <p>吾志所向，一往无前；愈挫愈勇，再接再厉。<br/>Victory won't come to me unless I go to it.</p>
    </div>
    <hr />
</div>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">


        <form method="post"  class="am-form" action="login.php">
            <label for="account">账号:</label>
            <input type="text" name='adminname' id="adminname">
            <br>
            <label for="password">密码:</label>
            <input type="password" name='password' id="password">
            <br>

            <br />
            <div class="am-cf">
                <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">

            </div>
        </form>
        <hr>
        <p>&copy;2017 Winbo, Inc. Licensed under MIT license.</p>
    </div>
</div>
</body>
</html>
