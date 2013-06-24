<?php
	define('PAGESIZE', 20);

	$origin = 'select logid, adminid, mailid, operation, rdate from v_admin_log where 1=1 ';

	if(array_key_exists('filter', $_GET) && $_GET['filter'] == '1') {
		$adminid = $_GET['adminid'];
		$mailid = $_GET['mailid'];
		$rdate = $_GET['rdate'];

		if($adminid) {
			$adminid = '%' . $adminid . '%';
			$origin .= ' and adminid like ? ';
		} else {
			$adminid = '%%';
			$origin .= ' and adminid like ? ';
		}

		if($mailid) {
			$mailid = '%' . $mailid . '%';
			$origin .= ' and mailid like ? ';
		} else {
			$mailid = '%%';
			$origin .= ' and mailid like ? ';
		}

		if($rdate) {
			$origin .= ' and TO_DAYS(rdate)<=TO_DAYS(?) ';
		} else {
			$rdate = '2099-12-31'; /* 也可以取当前日期 */
			$origin .= ' and TO_DAYS(rdate)<=TO_DAYS(?) ';
		}
	}

	if(array_key_exists('lastseen', $_GET) && $_GET['lastseen']) {
		$lastseen = $_GET['lastseen'];
		$origin .= ' and logid < ?';
	}

	$origin .= ' limit ' . PAGESIZE;

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

	if(array_key_exists('filter', $_GET) && $_GET['filter'] == '1' && array_key_exists('lastseen', $_GET) && $_GET['lastseen']) {
		if(!mysqli_stmt_bind_param($mysqli_stmt, 'sssi', $adminid, $mailid, $rdate, $lastseen)) {
			die('Statement Parameter Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
		}
	} else if (array_key_exists('filter', $_GET) && $_GET['filter'] == '1') {
		if(!mysqli_stmt_bind_param($mysqli_stmt, 'sss', $adminid, $mailid, $rdate)) {
			die('Statement Parameter Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
		}
	} else if (array_key_exists('lastseen', $_GET) && $_GET['lastseen']) {
		if(!mysqli_stmt_bind_param($mysqli_stmt, 'i', $lastseen)) {
			die('Statement Parameter Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
		}
	}

	if(!mysqli_stmt_execute($mysqli_stmt)) {
		die('Statement Execution Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_bind_result($mysqli_stmt, $logid, $adminid, $mailid, $operation, $rdate)) {
		die('Statement Result Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_store_result($mysqli_stmt)) {
		die('Statement Storing Result Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	while(mysqli_stmt_fetch($mysqli_stmt)) {
?>
	<div class="item">
		<span class="col-adminid"><?= $adminid ?></span>
		<span>将信件</span>
		<span class="col-mailid"><?= $mailid ?></span>
		<span class="col-operation"><?= $operation ?></span>
		<span class="col-rdate"><?= $rdate ?></span>
	</div>
<?php
	}

	mysqli_stmt_free_result($mysqli_stmt);
	mysqli_stmt_close($mysqli_stmt);
	mysqli_close($mysqli);
?>
