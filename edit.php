<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./assert/awesome/iconfont.css">
    <link rel="stylesheet" href="./css/edit.css">
    <title>编辑个人资料</title>
</head>
<body>
<form id="form">
    <ul class="list_wrapper">
        <li class="row avatar">
            <span>更改头像</span>
            <div class="btn-wrapper">
                <input type="file" name="avatar" style="visibility:hidden;position:absolute;">
                <input type="hidden" name="old" style="position:absolute">
                <input type="text" disabled class="fileMsg">
                <button type="button" class="btn upload">选择</button>
            </div>
        </li>
        <li class="row">
            <span>更改昵称</span>
            <input type="text" name="name">
        </li>
        <li class="row">
            <span>更改邮箱</span>
            <input type="text" name="email">
        </li>
        <li class="row">
            <span>更改编号</span>
            <input type="text" name="number">
        </li>
        <li class="row">
            <span>更改部门</span>
            <input type="text" name="depart">
        </li>
        <li class="row">
            <span>更改密码</span>
            <input type="text" name="psw">
        </li>
        <li class="row">
            <span>更改简介</span>
            <input type="text" name="abstract">
        </li>
    </ul>
    <button type="button" id="submit">提交</button>
</form>

<footer>
    <div class="home">
        <span class="icon icon-list"></span> 
        <ul>
            <li><a href="#"><span class="icon icon-home"></span></a></li> 
            <li><a href="javascript:history.back();"><span class="icon icon-aui-icon-back"></span></a></li>
        </ul>
    </div> 
    <div class="add-act">
        <a href="javascript:;">编辑资料</a>
    </div> 
    <div class="more">
        <button class="btn">
            <span class="spot"></span>
            <span class="spot"></span>
            <span class="spot"></span>
        </button> 
        <ul class="other">
            <li><a href="#"><span class="icon icon-circles" style="color: rgb(202, 138, 84);"></span>圈子</a></li> 
            <li><a href="activity.php"><span class="icon icon-group" style="margin-right: 5px; color: rgb(56, 86, 195);"></span> 活动</a></li> 
            <li><a href="ticket_list.php"><span class="icon icon-activityfill" style="color: rgb(106, 219, 224);"></span>电子票</a></li> 
            <li><a href="javascript:location.reload();"><span class="icon icon-refresh" style="color: rgb(17, 146, 51);"></span> 刷新</a></li>
        </ul>
    </div>
</footer>

<script src="./js/jquery.js"></script>
<script src="./js/edit.js"></script>
</body>
</html>