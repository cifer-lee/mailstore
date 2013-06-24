<?php
	$origin = 'select adminid, priv from admin where isroot=0b0';

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

	if(!mysqli_stmt_execute($mysqli_stmt)) {
		die('Statement Execution Fail, Error: (' . mysqli_stmt_errno($msyqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_bind_result($mysqli_stmt, $adminid, $priv)) {
		die('Statement Result Binding Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	if(!mysqli_stmt_store_result($mysqli_stmt)) {
		die('Statement Storing Result Fail, Error: (' . mysqli_stmt_errno($mysqli_stmt) . ')' . mysqli_stmt_error($mysqli_stmt));
	}

	while(mysqli_stmt_fetch($mysqli_stmt)) {
?>
	<div class="item">
		<span class="col-adminid"><?= $adminid ?></span>
		<span class="col-adminpriv"><?= $priv ?></span>
		<span class="col-nosuchadmin">
			<a href="libs/admin_delete.php?adminid=<?= $adminid ?>">删除</a>
		</span>
	</div>
<?php
	}

	mysqli_stmt_free_result($mysqli_stmt);
	mysqli_stmt_close($mysqli_stmt);
	mysqli_close($mysqli);
?>
