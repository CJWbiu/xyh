<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./assert/awesome/iconfont.css">
    <link rel="stylesheet" href="./css/ticket_list.css">
    <title>我的电子票</title>
</head>
<body>
<ul class="ticket-wrapper">
    <li>
        <a class="ticket" href="ticket.php">
            <div class="left">
                <p class="day">18/04/25</p>
                <p class="time">19:30</p>
            </div>
            <div class="right">
                <h3>大家讲堂jkfldajkflajfldajfklafjdkalfjkalfjkaljfkadljfkdalfjkalfdakfjkadl </h3>
                <p>有效期至2018-04-25 21:30</p>
                <p>上海交通大学闵行校区</p>
            </div>
        </a>
        <span class="flag">未使用</span>
    </li>
</ul>

<footer>
    <div class="home">
        <span class="icon icon-list"></span> 
        <ul>
            <li><a href="#"><span class="icon icon-home"></span></a></li> 
            <li><a href="javascript:history.back();"><span class="icon icon-aui-icon-back"></span></a></li>
        </ul>
    </div> 
    <div class="add-act">
        <a href="javascript:;">湖南科技大学校友微站</a>
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
<script src="./js/ticket_list.js"></script>
</body>
</html>