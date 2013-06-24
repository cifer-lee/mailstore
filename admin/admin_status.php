<div id="admin-status">
	<div id="filter"> 
		<form action="libs/admin_add.php" method="post">
			<label>Name</label>
			<input id="adminid" name="adminid" type="text" class="text-input" value="" />
			<label>密码</label>
			<input id="adminpass" name="adminpass" type="password" class="text-input" value="" />
			<label>权限</label>
			<select id="priv" name="priv">
				<option value="ROOT">ROOT权限</option>
				<option value="NORMAL">Normal</option>
				<option value="LOW">LOW</option>
			</select>

			<input id="" name="" type="submit" class="btn-input" value="添加" />
		</form>
	</div>
	<div class="item-header">
		<span class="col-adminid">Name</span>
		<span class="col-adminpriv">权限</span>
		<span class="col-nosuchadmin">删除此管理员？</span>
	</div>
	<?php require 'libs/admin_status_process.php' ?>
</div>
