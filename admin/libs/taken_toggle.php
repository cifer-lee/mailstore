<?php
	$origin = 'update mail set taken=? where mailid=?';

	$taken = $_GET['taken'];
	$mailid = $_GET['mailid'];

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

	mysqli_autocommit($mysqli, 0);

	$mysqli_stmt = mysqli_stmt_init($mysqli);
	if(!$mysqli_stmt) {
		die('Statement Initialization Fail, Error: (' . mysqli_errno($mysqli) . ')' . mysqli_error($mysqli)); 
	}

	if(!mysqli_stmt_prepare($mysqli_stmt, $origin)) {
		die('Statement Preparation Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}
	if(!mysqli_stmt_bind_param($mysqli_stmt, 'is', $taken, $mailid)) {
		die('Statement Parameter Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_execute($mysqli_stmt)) {
		mysqli_rollback($mysqli);
		die('Statement Execution Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(1 != mysqli_stmt_affected_rows($mysqli_stmt)) {
		mysqli_rollback($mysqli);
		die('Wrong affected rows, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	/* 记录管理员的操作 */
	session_start();
	$adminid = $_SESSION['adminid'];
	if($taken == 1) {
		$origin = "insert into admin_log (adminid, mailid, operation, rdate) values (?, ?, 'MAKETAKEN', NULL)";
	} else {
		$origin = "insert into admin_log (adminid, mailid, operation, rdate) values (?, ?, 'MAKEUNTAKEN', NULL)";
	}
	if(!mysqli_stmt_prepare($mysqli_stmt, $origin)) {
		mysqli_rollback($mysqli);
		die('Statement Preparation Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}
	if(!mysqli_stmt_bind_param($mysqli_stmt, 'ss', $adminid, $mailid)) {
		mysqli_rollback($mysqli);
		die('Admin log: Statement Parameter Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_execute($mysqli_stmt)) {
		mysqli_rollback($mysqli);
		die('Admin log: Statement Execution Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}
	if(1 != mysqli_stmt_affected_rows($mysqli_stmt)) {
		mysqli_rollback($mysqli);
		die('Admin log: Wrong affected rows, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	mysqli_commit($mysqli);

	session_write_close();
	mysqli_stmt_close($mysqli_stmt);
	mysqli_close($mysqli);

	header('Location: ../index.php?item=' . $_GET['item'] . '&filter=' . $_GET['filter'] . '&stuname=' . $_GET['stuname'] . '&stumajor=' . $_GET['stumajor'] . '&maildate=' . $_GET['maildate']);
?>
