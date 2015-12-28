<?php 

  //http_base验证
	error_reporting(0);	
  //用户名与密码设置
  $settings_dir = "../../settings";
  require_once "{$settings_dir}/conf.php";


	
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_USER']!=$admin || $_SERVER['PHP_AUTH_PW'] != $admin_pw || $_SESSION['logFlag']==0)  {

      // If empty, send header causing dialog box to appear
      
      header('WWW-Authenticate: Basic realm="Default user name:falcon          DefaultPassword:qq516974090"');
      header('HTTP/1.0 401 Unauthorized');
      echo 'Authorization Required.';

     
      $_SESSION['logFlag']=1;
      exit();
      
    } 

      

      $_SESSION['admin'] = $username;
		$_SESSION['admin_pw'] = $password;
	

  
?>