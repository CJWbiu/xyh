<?php

/**
 * 文件上传
 * @param  [type]  $fileInfo   [description]
 * @param  [type]  $allowType  [description]
 * @param  boolean $flag       [description]
 * @param  integer $maxSize    [description]
 * @param  string  $uploadPath [description]
 * @return [type]              [description]
 */
function _uploadFile($fileInfo,$allowType,$uploadPath='uploads',$flag=true,$maxSize=2097152){
    //提示上传失败错误
    if($fileInfo['error']>0){
        switch ($file['error']) {
            case 1:
                $msg= "文件超过服务器限制！";
                break;
            case 2:
                $msg= "文件超过了浏览器限制！";
                break;
            case 3:
                $msg= "文件只有部分被上传！";
                break;
            case 4:
                $msg= "文件没有被上传！";
                break;
            case 6:
                $msg= "找不到临时文件！";
                break;
            default:
                $msg= "系统错误！";
                break;
        }
        exit('{"errmsg":'.$msg.',"errcode":7}');
    }

    //判断文件类型
    $type=pathinfo($fileInfo['name'],PATHINFO_EXTENSION );
    if(!is_array($allowType)){
        exit('{"errmsg":"参数传递不正确","errcode":6}');
    }
    //$flag=true
    if($flag){
    if(!in_array($type, $allowType)){
            exit('{"errmsg":"不支持该类型文件！","errcode":5}');
    }
    //检测是否为真实文件
        if(!getimagesize($fileInfo['tmp_name'])){
            exit('{"errmsg":"请上传真实的图片文件！","errcode":4}');
        }
    }
    //判断文件大小
    // $maxSize=2097152;
    if($fileInfo['size']>$maxSize){
        exit('{"errmsg":"文件过大！","errcode":3}');
    }
    //检测是否通过POST方式上传
    if(!is_uploaded_file($fileInfo['tmp_name'])){
        exit('{"errmsg":"非法传输方式！","errcode":2}');
    }
    // $uploadPath='picture';
    //如果目录不存在就创建
    if(!file_exists($uploadPath)){
       mkdir($uploadPath,0777,true);
       chmod($uploadPath, 0777);
    }
    $uniName=md5(uniqid(microtime(true),true)).'.'.$type;
    $destination=$uploadPath.'/'.$uniName;
    if(!@move_uploaded_file($fileInfo['tmp_name'], $destination)){
        // echo $destination.'<br>';
        // echo $fileInfo['tmp_name'].'<br>';
        // echo dirname(__FILE__).'<br>';
        exit('{"errmsg":"上传失败！","errcode":1}');
    }	
    // echo '{"errmsg":"上传成功！","errcode":0}';
    return $destination;
}
?>