<?php
	define('PAGESIZE', 20);
	$origin = 'select mailid, mailfrom, mailto, majorname, type, maildate, taken from v_mail where 1=1 ';

	if(array_key_exists('filter', $_GET) && $_GET['filter'] == '1') {
		/*$stuname = $_POST['stuname'];
		$stumajor = $_POST['stumajor'];
		$maildate = $_POST['maildate'];
		*/
		$stuname = $_GET['stuname'];
		$stumajor = $_GET['stumajor'];
		$maildate = $_GET['maildate'];

		if($stuname) {
			$stuname = '%' . $stuname . '%';
			$origin .= ' and mailto like ? ';
		} else {
			$stuname = '%%';
			$origin .= ' and mailto like ? ';
		}

		if($stumajor && $stumajor != '00') {
			$origin .= ' and majorname=? ';
		} else {
			$stumajor = '%%';
			$origin .= ' and majorname like ? ';
		}

		if($maildate) {
			$origin .= ' and TO_DAYS(maildate)<=TO_DAYS(?) ';
		} else {
			$maildate = '2099-12-31'; /* 也可以取当前日期 */
			$origin .= ' and TO_DAYS(maildate)<=TO_DAYS(?) ';
		}
	}

	if(array_key_exists('lastseen', $_GET) && $_GET['lastseen']) {
		$lastseen = $_GET['lastseen'];
		$origin .= ' and mailid < ?';
	}

	$origin .= ' limit ' . PAGESIZE;

/*	print_r($origin);
	print_r($stuname);
	print_r($maildate);
	print_r($stumajor);

	die();
*/

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
		if(!mysqli_stmt_bind_param($mysqli_stmt, 'sssi', $stuname, $stumajor, $maildate, $lastseen)) {
			die('Statement Parameter Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
		}
	} else if (array_key_exists('filter', $_GET) && $_GET['filter'] == '1') {
		if(!mysqli_stmt_bind_param($mysqli_stmt, 'sss', $stuname, $stumajor, $maildate)) {
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

	if(!mysqli_stmt_bind_result($mysqli_stmt, $mailid, $mailfrom, $mailto, $major, $type, $maildate, $taken)) {
		die('Statement Result Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_store_result($mysqli_stmt)) {
		die('Statement Storing Result Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	while(mysqli_stmt_fetch($mysqli_stmt)) {
?>
	<div class="item">
		<span class="col-mailid"><?= $mailid ?></span>
		<span class="col-mailfrom"><?= $mailfrom ?></span>
		<span class="col-mailto"><?= $mailto ?></span>
		<span class="col-major"><?= $major ?></span>
		<span class="col-type"><?= $type ?></span>
		<span class="col-maildate"><?= $maildate ?></span>
		<span class="col-taken">
			<?php if($taken == '0') { ?>
			<a id="havetaken" href="libs/taken_toggle.php?item=1&mailid=<?= $mailid ?>&taken=1&filter=<?= $_GET['filter']?>&stuname=<?= $_GET['stuname']?>&stumajor=<?= $_GET['stumajor']?>&maildate=<?= $_GET['maildate']?>">已领取</a> | <span>未领取</span>
			<?php } else { ?>
			<span>已领取</span> | <a id="haventaken" href="libs/taken_toggle.php?item=1&mailid=<?= $mailid ?>&taken=0&filter=<?= $_GET['filter']?>&stuname=<?= $_GET['stuname']?>&stumajor=<?= $_GET['stumajor']?>&maildate=<?= $_GET['maildate']?>">未领取</a>
			<?php } ?>
		</span>
		<span class="col-nosuchmail">
			<a href="libs/mail_delete.php?item=1&mailid=<?= $mailid ?>&filter=<?= $_GET['filter']?>&stuname=<?= $_GET['stuname']?>&stumajor=<?= $_GET['stumajor']?>&maildate=<?= $_GET['maildate']?>">删除</a>
		</span>
	</div>
<?php
	}

	mysqli_stmt_free_result($mysqli_stmt);
	mysqli_stmt_close($mysqli_stmt);
	mysqli_close($mysqli);
?>
