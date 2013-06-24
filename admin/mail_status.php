<div id="mail-status">
	<div id="filter"> 
		<form action="index.php" method="get">
			<label>姓名</label>
			<input id="stuname" name="stuname" type="text" class="text-input" value="" />
			<label>专业</label>
			<select id="stumajor" name="stumajor">
				<option value="00">全部系</option>
				<?php require 'libs/fetch_major.php'; ?>
			</select>
			<label>日期</label>
			<input id="maildate" name="maildate" type="text" class="text-input" value="" />
			<input name="item" type="hidden" value="1" />
			<input name="filter" type="hidden" value="1" />

			<input id="" name="" type="submit" class="btn-input" value="过滤" />
		</form>
	</div>
	<div class="item-header">
		<span class="col-mailid">信件编号</span>
		<span class="col-mailfrom">发信人</span>
		<span class="col-mailto">收信人</span>
		<span class="col-major">收信人专业</span>
		<span class="col-type">信件类型</span>
		<span class="col-maildate">日期</span>
		<span class="col-taken">领取状态</span>
		<span class="col-nosuchmail">无此信件？</span>
	</div>
	<?php require 'libs/mail_status_process.php' ?>
	<div id="pager">
		<a href="index.php?item=1">Newest</a> | &lt; <a href="index.php?item=1&lastseen=<?= $mailid < PAGESIZE ? $mailid + 2 * PAGESIZE : $mailid ?>">Newer</a> <?php if($mailid != 1) { ?>| <a href="index.php?item=1&lastseen=<?= $mailid ?>">Older</a> <?php } ?>&gt;
	</div>
</div>
