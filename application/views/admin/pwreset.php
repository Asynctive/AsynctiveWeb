<h3>Password Reset</h3>

<?php if(isset($reset_sent)): ?>
<p>A reset e-mail has been sent</p>
<?php elseif(isset($reset_complete)): ?>
<p class="success">Password updated successfully</p>
<?php elseif(isset($resetting)): ?>
<form id="resetForm" class="cmxform" method="POST">
	<div class="form-group">
		<label for="pwreset-new-password">New Password:</label>
		<input id="pwreset-new-password" name="pwreset_new_password" type="password" class="form-control" placeholder="New Password" style="width: 200px">
		<?php echo form_error('pwreset_new_password') ?>
	</div>
	
	<div class="form-group">
		<input id="pwreset-confirm-password" name="pwreset_confirm_password" type="password" class="form-control" placeholder="Confirm New Password" style="width: 200px">
		<?php echo form_error('pwreset_confirm_password') ?>
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>
<?php else: ?>
<p>
	Request a password reset by entering your admin username. You will then recieve an e-mail
	which will allow you to enter a new password
</p>

<?php if(isset($reset_error)): ?>
<p class="error"><?php echo $reset_error ?></p>
<?php endif ?>

<form id="resetForm" class="cmxform" method="POST">
	<div class="form-group">
		<label for="pwreset-username">Username:</label>
		<input id="pwreset-username" name="pwreset_username" class="form-control" placeholder="Username" style="width: 200px">
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>
<?php endif ?>