<div id="mail-input">
	<form action="libs/mail_input_process.php" method="post">
		<div class="item">
			<label>信件编号</label>
			<input id="mailid" name="mailid" type="text" class="text-input" value="" />
		</div>
		<div class="item">
			<label>发信人</label>
			<input id="mailfrom" name="mailfrom" type="text" class="text-input" value="" />
		</div>
		<div class="item">
			<label>收信人</label>
			<input id="mailto" name="mailto" type="text" class="text-input" value="" />
		</div>
		<div class="item">
			<label>收信人专业</label>
			<select id="stumajor" name="stumajor">
				<?php require 'libs/fetch_major.php'; ?>
			</select>
		</div>
		<div class="item">
			<label>信件类型</label>
			<select id="mailtype" name="mailtype">
				<option value="EMS">EMS</option>
				<option value="挂号信">挂号信</option>
				<option value="包裹">包裹</option>
				<option value="信件">信件</option>
			</select>
		</div>
		<div class="item">
			<label>来信日期</label>
			<input id="maildate" name="maildate" type="text" class="text-input" value="" /> <span class="comment">格式: 2013-06-01</span>
		</div>
		<div class="item">
			<label></label>
			<input id="" name="" type="submit" class="btn-input" value="录入" />
		</div>
	</form>
</div>
