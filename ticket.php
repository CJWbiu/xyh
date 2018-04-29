<?php
require dirname(__FILE__).'/include/common.php';
require dirname(__FILE__).'/include/phpqrcode.php';

/** 扫码使用电子票 */
if(isset($_GET['action']) && $_GET['action'] == "use_ticket") {
    $t_id = $_GET['id'];
    $t_detail = _fetch_array("SELECT * FROM ticket WHERE t_id = '{$t_id}'");
    if($_COOKIE['username'] != $_GET['admin']) {
        echo '{"errcode": "7001","errmsg":"没有权限"}';
        _close();
        exit;
    }else {
        if($t_detail['t_flag'] == 1) {
            echo '{"errcode": "7000","errmsg":"票据已过期"}';
            _close();
            exit;
        }else {
            _query("
                    UPDATE ticket SET
                        t_flag=1
                    WHERE
                        t_id='{$t_id}'
            ");
            //判断是否修改成功
            if(mysql_affected_rows()==1){
                //获取新增的ID
                $_id=_insert_id();
                echo '{"errcode": "0000","errmsg":"验证通过请入场"}';
                _close();
                exit;
            }else{
                _close();
                echo '{"errcode":"6000","errmsg":"信息更新失败"}';
                exit;
            }
        }
    }
    
}

if(_is_login()) {
    $detail = _fetch_array("SELECT * FROM ticket WHERE t_id ='{$_GET['t_id']}'");
    $start = date("Y-m-d H:i",($detail['t_start']/1000));
    $end = date("Y-m-d H:i",($detail['t_end']/1000));
    if($detail['t_flag'] == 0) {
        $flagMsg = '<span class="flag" style="background: #4CAF50;">未使用</span>';
    }else {
        $flagMsg = '<span class="flag" style="background:rgb(155, 155, 155);">已使用</span>';
    }
    $value = 'http://www.pinkbluecp.cn:8000/xyh/ticket.php?action=use_ticket&admin=cheng&id='.$detail['t_id']; //二维码内容     
    $errorCorrectionLevel = 'L'; //容错级别     
    $matrixPointSize = 6; //生成图片大小  
  
    // 生成二维码图片     
    QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);  

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
            <a href="activity_detail.php?activity_id=<?php echo $detail['t_act_id']; ?>" class="t-content">
                <h3><?php echo $detail['t_title']; ?></h3>
                <p><?php echo $detail['t_place']; ?></p>
                <p><?php echo $start." ~ ".$end; ?></p>
                <span class="icon icon-down"></span>
            </a>
        </div>
        <div class="number">
            <div class="identify">
                <img src="qrcode.png" style="height:100%;">
            </div>
            <p class="tips">请签到管理人用微信扫描二维码进行验证</p>
        </div>
        <?php echo $flagMsg;?>
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
            <li><a href="personal.php"><span class="icon icon-group" style="margin-right: 5px; color: rgb(56, 86, 195);"></span> 个人信息</a></li> 
            <li><a href="activity.php"><span class="icon icon-activityfill" style="color: rgb(106, 219, 224);"></span>活动</a></li> 
            <li><a href="javascript:location.reload();"><span class="icon icon-refresh" style="color: rgb(17, 146, 51);"></span> 刷新</a></li>
        </ul>
    </div>
</footer>
<script src="./js/jquery.js"></script>  
<script src="./js/ticket.js"></script>    
</body>
</html>