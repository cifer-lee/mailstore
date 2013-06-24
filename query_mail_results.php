<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>信件查询系统</title>
		<link type="text/css" href="css/query_mail_results.css" rel="stylesheet">
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
			</div>
			<div id="maincontent">
				<div id="record-window"> 
					<div class="item-header">
						<span class="col-mailid col-title">信件编号</span>
						<span class="separator">|</span>
						<span class="col-mailfrom col-title">发信人</span>
						<span class="separator">|</span>
						<span class="col-mailto col-title">收信人</span>
						<span class="separator">|</span>
						<span class="col-major col-title">收信人专业</span>
						<span class="separator">|</span>
						<span class="col-type col-title">信件类型</span>
						<span class="separator">|</span>
						<span class="col-maildate col-title">信件日期</span>
						<span class="separator">|</span>
						<span class="col-taken col-title">领取状态</span>
					</div>
					<?php require 'libs/query_mail_process.php' ?>
				</div>
			</div>
			<div id="footer">
				<a href="index.php">返回</a>
			</div>
		</div>
	</body>
</html>
