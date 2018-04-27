<?php
    require dirname(__FILE__).'/include/common.php';
    if(_is_login()) {
        echo '<script>window.location.href="activity.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/login.css">
    <title>登录</title>
</head>
<body>
    <div class="container">
        <div class="logo"></div>
        <div class="form-wrapper">
            <div class="item">
                <span class="icon user"></span>
                <input id="user" type="text" placeholder="用户名">
                <div class="clear">
                    <span class="circle">
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </span>
                </div>
            </div>
            <div class="item">
                <span class="icon psw"></span>
                <input id="psw" type="password" placeholder="密码">
                <div class="clear">
                    <span class="circle">
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </span>
                </div>
            </div>
        </div>
        <button class="btn">登录</button>
        <p id="errmsg" style="display: none;"></p>
        <p class="bottom">
            <a class="reg" href="register.php" >注册</a> 
            <a href="activity.php">随便看看</a>
        </p>
    </div>

    <script src="./js/jquery.js"></script>
    <script src="./js/login.js"></script>
</body>
</html>