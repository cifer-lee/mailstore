<?php
	$stuname = $_POST['stuname'];
	$stumajor = $_POST['stumajor'];

	$origin = 'select mailid, mailfrom, mailto, majorname, type, taken, maildate from v_mail where mailto=? and majorid=?';

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

	if(!mysqli_stmt_bind_param($mysqli_stmt, 'ss', $stuname, $stumajor)) {
		die('Statement Parameter Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_execute($mysqli_stmt)) {
		die('Statement Execution Fail, Error: (' . mysqli_stmt_errno($msyqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_bind_result($mysqli_stmt, $mailid, $mailfrom, $mailto, $major, $type, $taken, $rdate)) {
		die('Statement Result Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_store_result($mysqli_stmt)) {
		die('Statement Storing Result Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	while(mysqli_stmt_fetch($mysqli_stmt)) {
?>
	<div class="item">
		<span class="col-mailid col-title"><?= $mailid ?></span>
						<span class="separator">|</span>
		<span class="col-mailfrom col-title"><?= $mailfrom ?></span>
						<span class="separator">|</span>
		<span class="col-mailto col-title"><?= $mailto ?></span>
						<span class="separator">|</span>
		<span class="col-major col-title"><?= $major ?></span>
						<span class="separator">|</span>
		<span class="col-type col-title"><?= $type ?></span>
						<span class="separator">|</span>
		<span class="col-maildate col-title"><?= $rdate?></span>
						<span class="separator">|</span>
		<span class="col-taken col-title"><?php if($taken == '1') { echo '已领取';} else { echo '未领取';} ?></span>
	</div>
<?php
	}

	mysqli_stmt_free_result($mysqli_stmt);
	mysqli_stmt_close($mysqli_stmt);
	mysqli_close($mysqli);
?>
