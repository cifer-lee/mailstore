<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>信件查询系统</title>
		<link type="text/css" href="css/index.css" rel="stylesheet">
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
			</div>
			<div id="maincontent">
				<div id="query-window"> 
					<form action="query_mail_results.php" method="post">
						<div class="item">
							<label>姓名</label> 
							<input id="stuname" name="stuname" class="text-input" type="text" value=""/>
						</div>
						<div class="item">
							<label>专业</label> 
							<select id="stumajor" name="stumajor">
								<option value="01">建筑系</option>
							</select>
						</div>
						<div class="item">
							<label></label> 
							<input id="" name="" class="btn-input" type="submit" value="查询"/>
						</div>
					</form>
				</div>
			</div>
			<div id="footer">
				<span class="copyright">©2013 - 2013 Cifer's Sanctuary, all rights reserved</span>
				<span style="float: right; font-size: 13px;"><a href="admin/index.php?item=1">管理员登录</a></span>
			</div>
		</div>
	</body>
</html> 
