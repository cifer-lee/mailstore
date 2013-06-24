<?php
	$mailid = $_POST['mailid'];
	$mailfrom = $_POST['mailfrom'];
	$mailto = $_POST['mailto'];
	$stumajor = $_POST['stumajor'];
	$mailtype = $_POST['mailtype'];
	$maildate = $_POST['maildate'];

	//$origin = 'insert into mail (mailid, mailfrom, mailto, major, type, rdate) values (?, ?, ?, ?, ?, ?)';
	$origin = 'insert into mail (mailfrom, mailto, major, type, rdate) values (?, ?, ?, ?, ?)';

	$mysqli = mysqli_init();
	if(!$mysqli) {
		die('mysqli_init failed');
	}

	if(!mysqli_real_connect($mysqli, 'localhost', 'root', 'foreverno.1', 'mailstore')) {
		die('Connect Fail, Error: (' . mysqli_connect_errno($mysqli) . ')' . mysqli_connect_error($mysqli));
	}
	if(!mysqli_set_charset($mysqli, 'utf8')) {
		die('Charset setting fail, current charset is' . mysqli_character_set_name($mysqli));
	}
	$mysqli_stmt = mysqli_stmt_init($mysqli);
	if(!$mysqli_stmt) {
		die('Statement Initialization Fail, Error: (' . mysqli_errno($mysqli) . ')' . mysqli_error($mysqli)); 
	}

	if(!mysqli_stmt_prepare($mysqli_stmt, $origin)) {
		die('Statement Preparation Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_bind_param($mysqli_stmt, 'sssss', $mailfrom, $mailto, $stumajor, $mailtype, $maildate)) {
		die('Statement Parameter Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_execute($mysqli_stmt)) {
		die('Statement Execution Fail, Error: (' . mysqli_stmt_errno($msyqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(1 != mysqli_stmt_affected_rows($mysqli_stmt)) {
		die('Wrong affected rows, Error: (' . mysqli_stmt_errno($msyqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	mysqli_stmt_close($mysqli_stmt);
	mysqli_close($mysqli);

	header('Location: ' . '../index.php?item=0');
?>
