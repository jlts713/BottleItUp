<?php
	//localhost
	$db_server = "localhost";
	$db_user = "root";
	$db_passwd = "root";
	$db_name = "u514530954_final";
	
	if(!@mysql_connect($db_server, $db_user, $db_passwd)){
			die("無法對資料庫連線");
	}
	
	mysql_query("SET NAMES utf8");
	
	if(!@mysql_select_db($db_name)){
			die("無法使用資料庫");
	}
	
?>