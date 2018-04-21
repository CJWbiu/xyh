<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./assert/awesome/iconfont.css">
    <link rel="stylesheet" href="./css/add_activity.css">
    <title>发布活动</title>
</head>
<body>
<form id="modify" enctype="multipart/form-data">
    <ul>
        <li class="upload_img">
            <span>图 片：</span>
            <div class="btn-wrapper">
                <input type="file" name="img" style="visibility:hidden;position:absolute;">
                <input type="text" disabled class="fileMsg">
                <button type="button" class="btn upload">选择</button>
            </div>
        </li>
        <li class="row"><span>标 题：</span><input type="text" autocomplete="off" name="title"></li>
        <li class="row">
            <span>类 型：</span>
            <div class="select">
                <input type="text" name="type" disabled>
                <button class="btn option-btn" id="type" type="button"><span class="icon icon-down"></span></button>
                <ul class="option-wrapper">
                    <li class="option">同学聚会</li>
                    <li class="option">座谈沙龙</li>
                    <li class="option">公益活动</li>
                    <li class="option">户外运动</li>
                    <li class="option">会议</li>
                </ul>
            </div>
        </li>
        <li class="row"><span>发 起：</span><input type="text" autocomplete="off" name="release"></li>
        <li class="row"><span>组 织：</span><input type="text" autocomplete="off" name="organizer"></li>
        <li class="row"><span>开 始：</span><input type="text" autocomplete="off" name="start" placeholder="格式：yyyy-MM-dd HH:mm"></li>
        <li class="row"><span>结 束：</span><input type="text" autocomplete="off" name="end" placeholder="格式：yyyy-MM-dd HH:mm"></li>
        <li class="row"><span>地 点：</span><input type="text" autocomplete="off" name="place"></li>
        <li class="row"><span>人 数：</span><input type="text" autocomplete="off" name="number"></li>
        <li class="desc">
            <span>描述：</span>
            <textarea name="desc"></textarea>
        </li>
    </ul>
    <input type="submit" value="提交" class="btn" id="submit">
    <p class="errInfo btn"></p>
</form>

<script src="./js/jquery.js"></script>
<script src="./js/add_activity.js"></script>
</body>
</html>
