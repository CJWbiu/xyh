<?php
require dirname(__FILE__).'./include/common.php';

if(isset($_COOKIE['username'])) {
    if(_fetch_array("SELECT u_id FROM user WHERE u_name = '{$_COOKIE['username']}' LIMIT 1")) {
        $detail = _fetch_array("SELECT * FROM ticket WHERE t_id ='{$_GET['t_id']}'");
        echo $detail;
    }else {
        echo '<script>alert("非法登录"); window.history.back()</script>';
    }
}else {  
        echo '<script>alert("请登录"); window.history.back()</script>';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./assert/awesome/iconfont.css">
    <link rel="stylesheet" href="./css/ticket.css">
    <title>电子票详情</title>
</head>
<body>
<div class="wrapper">
    <div class="bar"></div>
    <div class="content">
        <div class="info">
            <h1>电子票</h1>
            <a href="activity_detail.php" class="t-content">
                <h3>大家讲堂记录的房间昆仑山</h3>
                <p>上海交通大学闵行消歧义</p>
                <p>2018 ~ 2018</p>
                <span class="icon icon-down"></span>
            </a>
        </div>
        <div class="number">
            <div class="identify">1008</div>
            <p class="tips">fdafafafafafa</p>
        </div>
        <span class="flag">未使用</span>
    </div>
</div>

<footer>
    <div class="home">
        <span class="icon icon-list"></span> 
        <ul>
            <li><a href="#"><span class="icon icon-home"></span></a></li> 
            <li><a href="javascript:history.back();"><span class="icon icon-aui-icon-back"></span></a></li>
        </ul>
    </div> 
    <div class="add-act">
        <a href="javascript:;">我的电子票</a>
    </div> 
    <div class="more">
        <button class="btn">
            <span class="spot"></span>
            <span class="spot"></span>
            <span class="spot"></span>
        </button> 
        <ul class="other">
            <li><a href="#"><span class="icon icon-circles" style="color: rgb(202, 138, 84);"></span>圈子</a></li> 
            <li><a href="#"><span class="icon icon-group" style="margin-right: 5px; color: rgb(56, 86, 195);"></span> 个人信息</a></li> 
            <li><a href="#"><span class="icon icon-activityfill" style="color: rgb(106, 219, 224);"></span>活动</a></li> 
            <li><a href="javascript:location.reload();"><span class="icon icon-refresh" style="color: rgb(17, 146, 51);"></span> 刷新</a></li>
        </ul>
    </div>
</footer>
<script src="./js/jquery.js"></script>  
<script src="./js/ticket.js"></script>    
</body>
</html>