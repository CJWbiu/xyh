<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./assert/awesome/iconfont.css">
    <link rel="stylesheet" href="./css/activity.css">
    <title>活动列表</title>
</head>
<body>
<header>
    <div class="h-search">
        <input type="text" placeholder="查找所有活动" id="j_msg">
        <button id="j_search">
            <span class="icon icon-search"></span>
        </button>
    </div>
    <div class="search-filter">
        <div class="filter-option filter">
            <span class="text">筛选：</span>
            <span class="option default active">全部</span>
            <span class="option">最近一周</span>
            <button class="triangle">
                <span class="icon icon-down"></span>
            </button>
        </div>
        <div class="other-option" style="display:none;">
            <div class="filter-type filter">
                <span class="text">类型：</span> 
                <span class="option default active">不限类型</span>
                <span class="option">同学聚会</span>
                <span class="option">座谈沙龙</span>
                <span class="option">公益活动</span>
                <span class="option">户外运动</span>
                <span class="option">会议</span>
            </div>
        </div>
    </div>
</header>
<div id="list">
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
        <a href="./add_activity.php">发起活动</a>
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
            <li><a href="ticket_list.php"><span class="icon icon-activityfill" style="color: rgb(106, 219, 224);"></span>电子票</a></li> 
            <li><a href="javascript:location.reload();"><span class="icon icon-refresh" style="color: rgb(17, 146, 51);"></span> 刷新</a></li>
        </ul>
    </div>
</footer>
<script src="./js/jquery.js"></script>
<script src="./js/activity.js"></script>
</body>
</html>