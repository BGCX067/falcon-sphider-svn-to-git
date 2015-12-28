<?php 
	//error_reporting(0);	


$settings_dir = "../settings";
require_once "{$settings_dir}/conf.php";

session_start();

$htmlHeader=<<<HEAD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN">
<meta charset="utf-8">
	<head>
	<title>Sphider 管理登陆入口</title>
		<LINK REL=STYLESHEET HREF="admin.css" TYPE="text/css">
	</head>
  <body>
HEAD;
$htmlFooter=<<<FOOT
</body>
</html>
FOOT;

if (isset($_POST['user']) && isset($_POST['pass'])) {

          $username = $_POST['user'];
          $password = $_POST['pass'];
	if (($username == $admin) && ($password ==$admin_pw)) {
		$_SESSION['admin'] = $username;
		$_SESSION['admin_pw'] = $password;

	}else{
    echo $htmlHeader;
    echo <<<BACK
    请输入正确的用户名和密码!
<a href="http://www.falconlab.tk" style="font-size:0.8em;margin-left:5px;">需要帮忙?</a>
<a href="admin.php" style="font-size:0.8em;margin-left:5px;">返回</a>

BACK;
    echo $htmlFooter;
      die();
  }
	header("Location: admin.php");
        echo <<<BACK
    <a href="admin.php" style="font-size:0.8em;margin-left:15px;">如果不能跳转请点击</a>
BACK;
} elseif ((isset($_SESSION['admin']) && isset($_SESSION['admin_pw']) &&$_SESSION['admin'] == $admin && $_SESSION['admin_pw'] == $admin_pw ) ) {
      

} else {
	
   echo $htmlHeader;
	?>



	<center>
	<br><br>
	
	<fieldset style="width:30%;"><legend><b>Sphider 管理登陆入口</b></legend>
	<form action="auth.php" method="post">
	
	<table>
	<tr><td>管理帐号</td><td><input type="text" name="user"></td></tr>
	<tr><td>管理密码</td><td><input type="password" name="pass"></td></tr>
	<tr><td ><a title="Falconlab web实验室" href="http://www.falconlab.tk" style="vertical-align=bottom;text-decoration:none;color:#f00;margin-left:20px;">问题反馈?</a></td><td align=right><input type="submit" value="登陆" id="submit" ></td>
	</tr>

  </table>
	</form>
	</fieldset>
  
	</center>

	<?php 
    echo $htmlFooter;
	exit();
}


$settings_dir = "../settings";
include "$settings_dir/database.php";

?>