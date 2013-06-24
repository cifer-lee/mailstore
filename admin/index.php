<?php require 'libs/session_verify.php' ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>信件查询系统</title>
		<link type="text/css" href="css/index.css" rel="stylesheet">
		<link type="text/css" href="css/mail_input.css" rel="stylesheet">
		<link type="text/css" href="css/mail_status.css" rel="stylesheet">
		<link type="text/css" href="css/admin_status.css" rel="stylesheet">
		<link type="text/css" href="css/admin_logs.css" rel="stylesheet">
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<span id="greeting">管理员 <span style="color: red"><?= $_SESSION['adminid'] ?></span>, 您好！您可以,
				<a href="libs/change_pass.php">修改密码</a> <a href="logout.php">安全退出</a></span>
			</div>
			<div id="maincontent">
				<div class="menu">
					<div class="menu-item">
						<a href="index.php?item=0">信件信息录入</a>
					</div>
					<div class="menu-item">
						<a href="index.php?item=1&filter=0">信件状态管理</a>
					</div>
					<?php if($_SESSION['admin_priv'] == 'ROOT') { ?>
					<div class="menu-item">
						<a href="index.php?item=2">管理员账户管理</a>
					</div>
					<?php } ?>
					<div class="menu-item">
						<a href="index.php?item=3">管理员操作记录</a>
					</div>
				</div>
				<div class="menu-content">
					<?php 
						$item = $_GET['item']; 
						if($item == '0') {
					 		require 'mail_input.php';
						} else if($item == '1') {
					 		require 'mail_status.php'; 
						} else if($item == '2') {
					 		require 'admin_status.php'; 
						} else if($item == '3') {
					 		require 'admin_logs.php'; 
						}
					?>
				</div>
				<div class="clear"></div>
			</div>
			<div id="footer">
				<span class="copyright">©2013 - 2013 Cifer's Sanctuary, all rights reserved</span>
			</div>
		</div>
	</body>
</html>
