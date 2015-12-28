<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN" xml:lang="zh-CN">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<head>		
	<title>
Sphider 安装程序:修改以支持UTF-8 (by falcon)
	</title>
	<LINK REL=STYLESHEET HREF="admin.css" TYPE="text/css">
	</head>
<body>
<h2>Sphider 安装程序:</h2>
<h3>  　——修改以支持UTF-8 (by falcon)</h3>
<?php	//此处由丁廷臣修改，其实也无什么大不了的，就是把?换成?php
error_reporting(E_ALL);
$settings_dir = "../settings";
include "$settings_dir/database.php";

$error = 0;
mysql_query("create table `".$mysql_table_prefix."sites`(
	 `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `short_desc` text CHARACTER SET utf8,
  `indexdate` date DEFAULT NULL,
  `spider_depth` int(11) DEFAULT '2',
  `required` text CHARACTER SET utf8,
  `disallowed` text CHARACTER SET utf8,
  `can_leave_domain` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}
mysql_query("create table `".$mysql_table_prefix."links` (
 `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fulltxt` mediumtext CHARACTER SET utf8,
  `indexdate` date DEFAULT NULL,
  `size` float DEFAULT NULL,
  `md5sum` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `visible` int(11) DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`link_id`),
  KEY `url` (`url`),
  KEY `md5key` (`md5sum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}
mysql_query("create table `".$mysql_table_prefix."keywords`	(
  `keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`keyword_id`),
  UNIQUE KEY `kw` (`keyword`),
  KEY `keyword` (`keyword`(10))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}

for ($i=0;$i<=15; $i++) {
	$char = dechex($i);
	mysql_query("create table `".$mysql_table_prefix."link_keyword$char` (
  `link_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `weight` int(3) DEFAULT NULL,
  `domain` int(4) DEFAULT NULL,
  KEY `linkid` (`link_id`),
  KEY `keyid` (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

	if (mysql_errno() > 0) {
		print "错误: ";
		print mysql_error();
		print "<br>\n";
		$error += mysql_errno();
	}
}

mysql_query("create table `".$mysql_table_prefix."categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` text CHARACTER SET utf8,
  `parent_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}

mysql_query("create table `".$mysql_table_prefix."site_category` (
  `site_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}

mysql_query("create table `".$mysql_table_prefix."temp` (
  `link` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `id` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}

mysql_query("create table `".$mysql_table_prefix."pending` (
  `site_id` int(11) DEFAULT NULL,
  `temp_id` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}

mysql_query("create table `".$mysql_table_prefix."query_log` (
  `query` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `elapsed` float DEFAULT NULL,
  `results` int(11) DEFAULT NULL,
  KEY `query_key` (`query`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}

mysql_query("create table `".$mysql_table_prefix."domains` (
  `domain_id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`domain_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

if (mysql_errno() > 0) {
	print "错误: ";
	print mysql_error();
	print "<br>\n";
	$error += mysql_errno();
}


if ($error >0) {

	print "<b>创建表失败。具体请查阅上述错误信息。</b>";
} else {
  rename("install.php","install.php_bak".time()); //重命名安装文件
	print "<b>建立表顺利完成。 请到<a href=\"admin.php\">admin.php</a>开始索引。</b>";
}
?>
</body>
</html>