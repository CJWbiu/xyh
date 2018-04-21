<?php
require dirname(__FILE__).'./include/common.php';


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
            $result = _query("SELECT * FROM activity_list WHERE l_start <= $num LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list WHERE l_start <= $num");
            $total=mysql_result($all,0);
        }else {
            $result = _query("SELECT * FROM activity_list LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list");
            $total=mysql_result($all,0);
        }
    }else if(isset($_GET['type']) && isset($_GET['time'])) {
        if($_GET['time'] != '全部' && $_GET['type'] != '不限类型') {
            $num = time() + 604800;
            $result = _query("SELECT * FROM activity_list WHERE l_start <= $num AND l_type = '{$_GET['type']}' LIMIT $page, $pageSize");
            $all = _query("SELECT COUNT(*) FROM activity_list WHERE l_start <= $num AND l_type = '{$_GET['type']}'");
            $total=mysql_result($all,0);
        }else if($_GET['time'] != '全部' && $_GET['type'] == '不限类型') {
            $num = time() + 604800;
            $result = _query("SELECT * FROM activity_list WHERE l_start <= $num LIMIT $page, $pageSize");
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
    if($page >= $total) {
        echo '{"isend": 1}';
    }else {
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $row['start'] = @date("Y-m-d H:i",$row['start']);
            $row['end'] = @date("Y-m-d H:i",$row['end']);
            array_push($list, $row);
        }
        echo json_encode($list);
    }

}

//添加活动
if(isset($_POST['action'])) {
    if($_POST['action'] == 'add_activity') {
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
            echo '{"errcode":0,"l_id":'.$_id.'}';
        }else{
            _close();
            echo '{"errcode":1,"errmsg":"数据库写入失败"}';
        }
    }
}
?>