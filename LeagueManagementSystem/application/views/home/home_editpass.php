<?php
	if (isset($_POST))
	{
		echo 'Hello.';
	}
?>

<form action="<?php echo base_url(); ?>index.php/home/editPassword" method="post">
	<div class="control-group">
		<label class="control-label">Current Password</label>
		<div class="controls">
			<input type="password" name="oldpass" data-validation-required-message="This field is required." required />
			<p class="help-block"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">New Password</label>
		<div class="controls">
			<input type="password" name="newpass" data-validation-required-message="This field is required." required />
			<p class="help-block"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Confirm New Password</label>
		<div class="controls">
			<input type="password" data-validation-match-message="Passwords do not match." data-validation-required-message="This field is required." data-validation-match-match="newpass" name="confirm_newpass" required />
			<p class="help-block"></p>
		</div>
	</div>
</form>
<button type="submit" class="btn btn-primary">Change Password</button>