<?php
require dirname(__FILE__).'./include/common.php';
$msg = '';
$isenroll = true;
if(isset($_GET['activity_id'])) {
    $detail = _fetch_array("SELECT * FROM activity_list WHERE id ='{$_GET['activity_id']}'");
    _query("UPDATE activity_list SET l_read=l_read+1 WHERE id='{$_GET['activity_id']}'");
    // print_r($detail);
    if(@strtotime(date("Y-m-d H:i")) - $detail['l_end'] < 0) {
        if(_fetch_array("SELECT t_id FROM ticket WHERE t_user = '{$_COOKIE['username']}' AND t_act_id = '{$detail['id']}'")) {
            $msg = "已报名";
            $isenroll = false;
            _close();
        }else {
            $msg = "报名";
            $isenroll = true;
            _close();
        }
    }else {
        $msg = "已过期";
            $isenroll = false;
    }
    $detail['l_start'] = @date("Y-m-d H:i",$detail['l_start']);
    $detail['l_end'] = @date("Y-m-d H:i",$detail['l_end']);
    echo $msg;
    echo $isenroll;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximun-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./assert/awesome/iconfont.css">
    <link rel="stylesheet" href="./css/activity_detail.css">
    <title>活动详情</title>
</head>
<body>
<div class="img-wrapper" style="background: url('<?php echo $detail['l_img'] ?>')">
    <h3><?php echo $detail['l_title'] ?></h3>
</div>
<ul class="activity-info">
    <li>组织：<?php echo $detail['l_organizer'] ?></li>
    <li>时间：<?php echo $detail['l_start'] ?></li>
    <li>地点：<?php echo $detail['l_place'] ?></li>
    <li>
        人数： <?php echo $detail['l_number'] ?>
        <span class="exist" v-if="detail.exist>0">(已有{{detail.exist}}人参加)</span>
    </li>
    <li>
        距结束报名：<span>{{surplus.day}}天后</span>
        <span class="box">{{surplus.hour}}</span>:
        <span class="box">{{surplus.minute}}</span>:    
        <span class="box">{{surplus.second}}</span>
    </li>
</ul>
<div class="item">
    <h3 class="item-title">活动参与者</h3>
    <div class="actor-list">
        <span class="avatar"></span>
        <span class="avatar"></span>
        <span class="avatar"></span>
        <span class="showDetail"></span>
    </div>
</div>

<div class="item">
    <h3 class="item-title">讨论交流</h3>
    <div class="comment">
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
        <a href="javascript:;" data-flag="<?php echo $isenroll; ?>" data-id="<?php echo $detail['id']; ?>" data-end="<?php echo $detail['l_end']; ?>">
            <?php echo $msg; ?>
        </a>
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
<script src="./js/activity_detail.js"></script>
</body>
</html>