<?php
	require_once(realpath(dirname(__FILE__)) .'/../env.php');	
	
	if(ENV == 'production') {
		//生产环境
		$database="a0103133301"; //数据库名
		$mysql_user = "a0103133301";//数据库用户
		$mysql_password = "7340985"; //数据库密码
		$mysql_host = "111.92.232.85";//数据库主机
		//$mysql_table_prefix = "";//表前缀,可不填
		$mysql_table_prefix = "sp_";
	}
	
	if(ENV == 'development') {
		$database="sphider"; //数据库名
		$mysql_user = "root";//数据库用户
		$mysql_password = "root"; //数据库密码
		$mysql_host = "localhost";//数据库主机
		$mysql_table_prefix = "";//表前缀,可不填
		//$mysql_table_prefix = "falcon_";
	}
	
	$success = mysql_pconnect ($mysql_host, $mysql_user, $mysql_password);
	if (!$success)
		die ("<b>不能连接到数据库，请检查用户名，密码和主机是否正确。</b>");
    $success = mysql_select_db ($database);
    // mysql_query("SET NAMES UTF8");
    mysql_set_charset("UTF8"); 
	if (!$success) {
		print "<b>不能连接到数据库，请检查数据库名是否正确。";
		die();
	}
?>

