<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./assert/awesome/iconfont.css">
    <link rel="stylesheet" href="./css/personal.css">
    <title>个人中心</title>
</head>
<body>
<div class="info_wrapper">
    <div class="header"></div>
    <div class="user">
        <div class="avatar_wrapper">
            <img id="avatar" src="./assert/bground/avatar.png" alt="avatar">
        </div>
        <div class="u_info">
            <h1 id="u_name">法克大叔叔</h1>
            <p id="abstract"><span>简介：</span></p>
        </div>
    </div>
    <ul class="u_other">
        <li>
            <span>编号:</span>
            <p id="number"></p>
        </li>
        <li>
            <span>部门:</span> 
            <p id="depart"></p>
        </li>
        <li>
            <span>邮箱:</span> 
            <p id="email"></p>
        </li>
    </ul>
    <a class="btn" href="javascritp:;" id="edit">编辑个人资料</a>
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
        <a href="javascript:;">个人中心</a>
    </div> 
    <div class="more">
        <button class="btn">
            <span class="spot"></span>
            <span class="spot"></span>
            <span class="spot"></span>
        </button> 
        <ul class="other">
            <li><a href="activity.php"><span class="icon icon-group" style="margin-right: 5px; color: rgb(56, 86, 195);"></span> 活动</a></li> 
            <li><a href="ticket_list.php"><span class="icon icon-activityfill" style="color: rgb(106, 219, 224);"></span>电子票</a></li> 
            <li><a href="javascript:location.reload();"><span class="icon icon-refresh" style="color: rgb(17, 146, 51);"></span> 刷新</a></li>
        </ul>
    </div>
</footer>

<script src="./js/jquery.js"></script>
<script src="./js/personal.js"></script>
</body>
</html>