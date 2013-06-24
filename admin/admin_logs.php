<div id="admin-logs">
	<div id="filter"> 
		<form action="index.php" method="get">
			<label>管理员ID</label>
			<input id="adminid" name="adminid" type="text" class="text-input" value="" />
			<label>信件编号</label>
			<input id="mailid" name="mailid" type="text" class="text-input" value="" />
			<label>日期</label>
			<input id="rdate" name="rdate" type="text" class="text-input" value="" />
			<input name="item" type="hidden" value="3" />
			<input name="filter" type="hidden" value="1" />

			<input id="" name="" type="submit" class="btn-input" value="过滤" />
		</form>
	</div>
	<div class="item-header">
		<span class="col-adminid">管理员ID</span>
		<span style="width: 40px;"></span>
		<span class="col-mailid">信件编号</span>
		<span class="col-operation">操作</span>
		<span class="col-rdate">操作时间</span>
	</div>
	<?php require 'libs/admin_logs_process.php' ?>
	<div id="pager">
		<a href="index.php?item=3">Newest</a> | &lt; <a href="index.php?item=3&lastseen=<?= $logid < PAGESIZE ? $logid + 2 * PAGESIZE : $logid ?>">Newer</a> <?php if($logid != 1) { ?>| <a href="index.php?item=3&lastseen=<?= $logid ?>">Older</a> <?php } ?>&gt;
	</div>
</div>
