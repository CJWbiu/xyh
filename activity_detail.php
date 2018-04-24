<?php
    require dirname(__FILE__).'./include/common.php';
    $msg = '';
    $isenroll = true;
    if(isset($_GET['activity_id']) && _is_login("username")) {
        $detail = _fetch_array("SELECT * FROM activity_list WHERE id ='{$_GET['activity_id']}'");
        _query("UPDATE activity_list SET l_read=l_read+1 WHERE id='{$_GET['activity_id']}'");

        $all = _query("SELECT COUNT(*) FROM ticket WHERE t_user = '{$_COOKIE['username']}'");
        $total=mysql_result($all,0);

        if(@strtotime(date("Y-m-d H:i")) - $detail['l_end'] < 0) {
            if(_fetch_array("SELECT t_id FROM ticket WHERE t_user = '{$_COOKIE['username']}' AND t_act_id = '{$detail['id']}'")) {
                $msg = "已报名(取消报名)";
                $isenroll = 2;
                _close();
            }else {
                $msg = "报名";
                $isenroll = 1;
                _close();
            }
        }else {
            $msg = "已过期";
                $isenroll = 0;
        }
        $detail['l_start'] = @date("Y-m-d H:i",$detail['l_start']);
        $detail['l_end'] = @date("Y-m-d H:i",$detail['l_end']);
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
    <link rel="stylesheet" href="./css/activity_detail.css">
    <title>活动详情</title>
</head>
<body>
<div class="img-wrapper" style="background: url('<?php echo $detail['l_img'] ?>')">
    <h3><?php echo $detail['l_title'] ?></h3>
</div>
<ul class="activity-info">
    <li>组织：<?php echo $detail['l_organizer'] ?></li>
    <li>时间：<?php echo $detail['l_start'].' ~ '.$detail['l_end']?></li>
    <li>地点：<?php echo $detail['l_place'] ?></li>
    <li>
        人数： <?php echo $detail['l_number'] ?>
        <span class="exist">(已有<?php  echo $total; ?>人参加)</span>
    </li>
    <li>
        距结束报名：<span id="time"></span>
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
        <div class="all-day">
            <p class="d-time">2018-04-05</p>
            <div class="c-item">
                <div class="c-avatar"></div>
                <div class="c-info">
                    <p class="c-top">
                        <span class="c-name">cheng</span>
                        <span class="c-time">23:56</span>
                    </p>
                    <p class="c-bottom">期待</p>
                </div>
            </div>
            <div class="c-item me">
                <div class="c-avatar"></div>
                <div class="c-info">
                    <p class="c-top">
                        <span class="c-name">cheng</span>
                        <span class="c-time">23:56</span>
                    </p>
                    <p class="c-bottom">期待</p>
                </div>
            </div>
        </div>
    </div>
    <div class="msg-send">
        <input type="text" id="s-msg">
        <button id="send">发送</button>
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
        <a href="javascript:;"
            data-flag="<?php echo $isenroll; ?>" 
            data-flag="<?php echo $isenroll; ?>" 
            data-id="<?php echo $detail['id']; ?>" 
            data-end="<?php echo $detail['l_end']; ?>"
            data-start="<?php echo $detail['l_start']; ?>"
            data-place="<?php echo $detail['l_place']; ?>"
            data-title="<?php echo $detail['l_title']; ?>"
        >
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
            <li><a href="activity.php"><span class="icon icon-activityfill" style="color: rgb(106, 219, 224);"></span>活动</a></li> 
            <li><a href="javascript:location.reload();"><span class="icon icon-refresh" style="color: rgb(17, 146, 51);"></span> 刷新</a></li>
        </ul>
    </div>
</footer>


<script src="./js/jquery.js"></script>  
<script src="./js/activity_detail.js"></script>
<script>
    let endTime = "<?php echo $detail['l_end'] ?>";
    endTime = new Date(endTime).getTime();

    timer();

    function timer() {
        const set = function(num) {
                if(num < 10) {
                    return "0" + num;
                }else {
                    return num;
                }
            };
        let now = new Date().getTime();
        let res = endTime - now;
        let day = Math.floor(res/(1000*3600*24));
        res = res%(1000*3600*24);
        let hour = Math.floor(res/(1000*3600));
        res = res%(1000*3600);
        let minute = Math.floor(res/(1000*60));
        res = res%(1000*60);
        let second = Math.floor(res/1000);
        let str = `
            <span class="day">${set(day)}天后</span>
            <span class="box">${set(hour)}</span>:
            <span class="box">${set(minute)}</span>:    
            <span class="box">${set(second)}</span>`;
        document.querySelector('#time').innerHTML = str;
        setTimeout(() => {
            timer();
        }, 500);
    }
</script>

</body>
</html>