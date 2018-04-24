<?php
require dirname(__FILE__).'./include/common.php';
setcookie('username','cheng',time()+604800);

//读取活动列表
if($_GET['action'] == 'getList') {
    $page = $_GET['page'];
    $pageSize = $_GET['size'];

    if(isset($_GET['input'])) {
        $input = $_GET['input'];
        $result = _query("SELECT * FROM activity_list WHERE l_title LIKE '%".$input."%' LIMIT $page, $pageSize");
        $all = _query("SELECT COUNT(*) FROM activity_list WHERE l_title LIKE '%".$input."%'");
        $total=mysql_result($all,0);
    }else if(isset($_GET['type']) && !isset($_GET['time'])) {
        if($_GET['type'] != '不限类型') {
            $result = _query("SELECT * FROM activity_list WHERE l_type ='{$_GET['type']}' LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list WHERE l_type ='{$_GET['type']}'");
            $total=mysql_result($all,0);
        }else {
            $result = _query("SELECT * FROM activity_list LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list");
            $total=mysql_result($all,0);
        }
    }else if(!isset($_GET['type']) && isset($_GET['time'])) {
        if($_GET['time'] != '全部') {
            $num = time() + 604800;
            $now = time();
            $result = _query("SELECT * FROM activity_list WHERE l_start <= $num AND l_start >= $now LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list WHERE l_start <= $num AND l_start >= $now");
            $total=mysql_result($all,0);
        }else {
            $result = _query("SELECT * FROM activity_list LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list");
            $total=mysql_result($all,0);
        }
    }else if(isset($_GET['type']) && isset($_GET['time'])) {
        if($_GET['time'] != '全部' && $_GET['type'] != '不限类型') {
            $num = time() + 604800;
            $now = time();
            $result = _query("SELECT * FROM activity_list WHERE l_start <= $num AND l_start >= $now AND l_type = '{$_GET['type']}' LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list WHERE l_start <= $num AND l_start >= $now AND l_type = '{$_GET['type']}'");
            $total=mysql_result($all,0);
        }else if($_GET['time'] != '全部' && $_GET['type'] == '不限类型') {
            $num = time() + 604800;
            $now = time();
            $result = _query("SELECT * FROM activity_list WHERE l_start <= $num AND l_start >= $now LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list WHERE l_start <= $num");
            $total=mysql_result($all,0);
        }else if($_GET['time'] == '全部' && $_GET['type'] != '不限类型') {
            $result = _query("SELECT * FROM activity_list WHERE l_type ='{$_GET['type']}' LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list WHERE l_type ='{$_GET['type']}'");
            $total=mysql_result($all,0);
        }else {
            $result = _query("SELECT * FROM activity_list LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list");
            $total=mysql_result($all,0);
        }
    }else {
        $result = _query("SELECT * FROM activity_list LIMIT $page, $pageSize");
        $all = _query("SELECT COUNT(*) FROM activity_list");
        $total=mysql_result($all,0);
    }

    $list = array();
    // echo 'page='.$page.'--total='.$total;
    if($page == 0 && $total == 0) {
        echo '{"isempty":1}';
        exit();
    }else if($page >= $total) {
        echo '{"isend": 1}';
    }else {
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $row['l_start'] = @date("Y-m-d H:i",$row['l_start']);
            $row['l_end'] = @date("Y-m-d H:i",$row['l_end']);
            //判断是否已报名
            if(_fetch_array("SELECT t_id FROM ticket WHERE t_user = '{$_COOKIE['username']}' AND t_act_id = '{$row['id']}'")) {
                $row['isenroll'] = true;
            }else {
                $row['isenroll'] = false;
            }
            $alllike = _query("SELECT COUNT(*) FROM act_like WHERE act_id = '{$row['id']}'");
            $likenum=mysql_result($alllike,0);
            $row['l_like'] = $likenum;
            array_push($list, $row);
        }
        echo json_encode($list);
    }

}

//点赞
if(isset($_GET['action']) && $_GET['action'] == 'like') {
    if(_is_login("username")) {
        $act_id = $_GET['act_id'];
        $sql = "SELECT id FROM act_like WHERE user_name='{$_COOKIE['username']}' AND act_id = '{$act_id}'";
        
        if(_fetch_array($sql)) {
            echo '{"errcode":"2000","errmsg": "已点赞"}';
            _close();
        }else {
            _query("
                INSERT INTO act_like (
                                    act_id,
                                    user_name
                                )
                            VALUES (
                                    '{$act_id}',
                                    '{$_COOKIE['username']}'
                                ) 
                ");
            if(_affected_rows() == 1) {
                echo '{"errcode":"0000","errmsg":"修改成功"}';
                _close();
            }else {
                echo '{"errcode":"2001","errmsg":"修改失败"}';
                _close();
            }
        }
    }else {
        echo '{"errcode":"1000","errmsg": "请登录"}';
        exit();
    }
}
//报名
if(isset($_POST['action']) && $_POST['action'] == 'join') {
    if(_is_login('username')) {
        if(_fetch_array("SELECT t_id FROM ticket WHERE t_user = '{$_COOKIE['username']}' AND t_act_id = '{$_GET['act_id']}'")) {
            echo '{"errcode": "3000","errmsg":"已经报过名"}';
            _close();
        }else {
            _query("
                INSERT INTO ticket (
                                    t_act_id,
                                    t_user,
                                    t_end,
                                    t_start,
                                    t_title,
                                    t_place
                                )
                            VALUES (
                                    '{$_POST['act_id']}',
                                    '{$_COOKIE['username']}',
                                    '{$_POST['end']}',
                                    '{$_POST['start']}',
                                    '{$_POST['title']}',
                                    '{$_POST['place']}'
                                ) 
                ");
            if(mysql_affected_rows()==1){
                $_id=_insert_id();
                echo '{"errcode": "0000","t_id":"'.$_id.'"}';
                _close();
            }else {
                echo '{"errcode": "3001","errmsg":"报名失败"}';
                _close();
            }
        }
    }else {
        echo '{"errcode": "1000", "errmsg":"请登录"}';
    }
}
//取消报名
if(isset($_POST['action']) && $_POST['action'] == 'esc_join') {
    if(_is_login('username')) {
        $t_act_id = $_POST['t_act_id'];
        _query("DELETE FROM ticket WHERE t_act_id = '{$t_act_id}' AND t_user = '{$_COOKIE['username']}'");
        if(_affected_rows() == 1) {
            echo '{"errcode":"0000","errmsg":"修改成功"}';
            _close();
        }else {
            echo '{"errcode":"3002","errmsg":"取消报名失败"}';
            _close();
        }
    }else {
        echo '{"errcode":"1000","errmsg": "请登录"}';
        exit();
    }
}
//读取电子票列表
if(isset($_GET['action']) && $_GET['action'] == 'all_ticket') {
    if(_is_login('username')) {
        $ticket_list = array();
        $sql = "SELECT * FROM ticket WHERE t_user = '{$_COOKIE['username']}'";
        $tickets = _query($sql);
        while($ticket = mysql_fetch_array($tickets,MYSQL_ASSOC)) {
            array_push($ticket_list, $ticket);
        }
        echo json_encode($ticket_list);
    }else {
        echo '{"errcode": "1000", "errmsg":"请登录"}';
    }
}

//添加活动
if(isset($_POST['action']) && ($_POST['action'] == 'add_activity')) {
    if(_is_login("username")) {
        $info = array();
        $allowType=array('jpeg','gif','png','jpg');
        $info['img'] = _uploadFile($_FILES['img'],$allowType);
        $info['title'] = $_POST['title'];
        $info['type'] = $_POST['type'];
        $info['release'] = $_POST['release'];
        $info['organizer'] = $_POST['organizer'];
        $info['start'] = @strtotime($_POST['start']);
        $info['end'] = @strtotime($_POST['end']);
        $info['place'] = $_POST['place'];
        $info['number'] = $_POST['number'];
        $info['desc'] = $_POST['desc'];

        _query(
            "INSERT INTO activity_list(
                                l_title,
                                l_type,
                                l_release,
                                l_organizer,
                                l_start,
                                l_end,
                                l_place,
                                l_number,
                                l_desc,
                                l_img
                            ) 
                    VALUES(
                                '{$info['title']}',
                                '{$info['type']}',
                                '{$info['release']}',
                                '{$info['organizer']}',
                                '{$info['start']}',
                                '{$info['end']}',
                                '{$info['place']}',
                                '{$info['number']}',
                                '{$info['desc']}',
                                '{$info['img']}'
                                )"
            );
        //判断是否修改成功
        if(mysql_affected_rows()==1){
            //获取新增的ID
            $_id=_insert_id();
            _close();
            echo '{"errcode":"0000","id":'.$_id.'}';
        }else{
            _close();
            echo '{"errcode":"4000","errmsg":"数据库写入失败"}';
        }
    }else {
        echo '{"errcode": "1000","errmsg":"请登录"}';
        exit();
    }
}

/** 评论 */
if(isset($_POST['action']) && ($_POST['action'] == 'comment') && _is_login('username')) {
    $c_act_id = $_POST['act_id'];
    $c_user = $_COOKIE['username'];
    $c_content = $_POST['content'];
    if(_fetch_array("SELECT t_id FROM ticket WHERE t_user = '{$c_user}' AND t_act_id = '{$c_act_id}'")) {
        _query("
            INSERT INTO comment(
                            c_user,
                            c_time,
                            c_content,
                            c_act_id
                        )
                        VALUES(
                            '{$c_user}',
                            NOW(),
                            '{$c_content}',
                            '{$c_act_id}'
                        )
        ");
        //判断是否修改成功
        if(mysql_affected_rows()==1){
            //获取新增的ID
            $_id=_insert_id();
            _close();
            echo '{"errcode":"0000","id":'.$_id.'}';
        }else{
            _close();
            echo '{"errcode":"4000","errmsg":"数据库写入失败"}';
        }
    }else {
        echo '{"errcode": "3002", "errmsg": "未报名"}';
        _close();
    }
}
?>