<?php
//引入核心函数库
require dirname(__FILE__).'./global.php';
require dirname(__FILE__).'./mysql.php';
date_default_timezone_set("Asia/Shanghai");
//数据库连接
define('DB_USER', 'root');
define('DB_HOST', 'localhost');	//139.199.71.63
define('DB_PSW', '123456789');
define('DB_NAME', 'sign_people');
//初始化数据库
_connect();
_select_db();
_set_names();

?>