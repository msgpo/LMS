<?php
	if (isset($_POST))
	{
		echo 'Hello.';
	}
?>
<style type="text/css">
	p1{
		color:red;
    }
</style>
<form action="<?php echo base_url(); ?>index.php/home/edit" method="post">
	<div class="control-group">
		<label class="control-label">Current Password</label>
		<div class="controls">
			<input type="password" name="oldpass" >
			<p class="help-block"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">New Password</label>
		<div class="controls">
			<input type="password" name="newpass" >
			<p class="help-block"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Confirm New Password</label>
		<div class="controls">
			<input type="password" name="pass_confirm">
			<p class="help-block"></p>
		</div>
		<p1 <?php echo validation_errors(); ?> </p1>
	</div>
<button type="submit" class="btn btn-primary">Change Password</button>
</form>