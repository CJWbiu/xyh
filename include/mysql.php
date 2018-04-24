<?php 

/**
*_connect() 连接数据库
*@access public
*@return void
*/
function _connect(){
	global $_conn;
	if(!$_conn= @mysql_connect(DB_HOST,DB_USER,DB_PSW)){
		exit('数据库连接失败！');
    }

}

/**
*_select_db() 选择数据表
*@access public
*@return void
*/
function _select_db(){
	if(!mysql_select_db(DB_NAME)){
		exit('找不到指定数据库！');
	}

}


/**
*_set_names() 设置字符集
*@access public
*@return void
*/
function _set_names(){
	if(!mysql_query('set names utf8')){
		exit('字符集错误！');
	}

}
/**
*_query() 判断sql语句是否执行失败
*/
function _query($_sql){
	// echo $_sql;
	if(!$result=mysql_query($_sql)){
		exit('SQL语句执行失败！'.mysql_error());
	}
	return $result;
}
/**
 * 获取新用户ID
 * @return [type] [description]
 */
function _insert_id(){
	return mysql_insert_id();
}

/**
 * 获取结果集 
 * @$_sql 数据库语句
 */
function _fetch_array($_sql){
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}


/**
*_close() 关闭数据库
*/
function _close(){
	if(!mysql_close()){
		exit('关闭异常！');
	}
}
/**
 * 判断用户是否登录
 * @$key cookie存储字段
 */
function _is_login($key){
	if(isset($_COOKIE[$key]) && _fetch_array("SELECT u_id FROM user WHERE u_name = '{$_COOKIE[$key]}' LIMIT 1")) {
		return true;
	}else {
		return false;	
	}
}
?>