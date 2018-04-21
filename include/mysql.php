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
 * 销毁结果集
 * @param  [result] $_result 
 * @return [type]          
 */
function _free_result($_result){
	mysql_free_result($_result);
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


function _fetch_array($_sql){
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}
/**
*_fetch_array() mysql_fetch_array() 直接返回结果集
*/
function _fetch_array_list($_res){
	return mysql_fetch_array($_res,MYSQL_ASSOC);
}
/**
*_affected_rows() 返回记录行数
*/
function _affected_rows(){
	return mysql_affected_rows();
}
/**
*_is_repeat() 判断用户名是否重复
*/
function _is_repeat($_sql,$_info){
	if(_fetch_array($_sql)){
		_alert_back($_info);
	}
}
/**
*_num_rows() 返回数据表总行数
*/
function _num_rows($_result){
	return mysql_num_rows($_result);
}
/**
*_close() 关闭数据库
*/
function _close(){
	if(!mysql_close()){
		exit('关闭异常！');
	}
}
?>