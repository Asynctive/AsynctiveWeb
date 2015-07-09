<h3>Password Reset</h3>

<?php if(isset($reset_sent)): ?>
<p>A password reset e-mail has been sent to: <span style="font-style: italic"><?php echo $reset_email ?></span></p>
<p><a href="/pwreset">Go back</a></p>

<?php elseif(isset($reset_complete)): ?>
<p style="color: #00aa00">Password was reset successfully</p>
<p><a href="/">Go back</a></p>

<?php elseif(isset($resetting)): ?>
<form id="resetForm" class="cmxform" method="POST">
	<div class="form-group">
		<label for="pwreset-new-password">New Password:</label>
		<input id="pwreset-new-password" name="pwreset_new_password" type="password" class="form-control" placeholder="New Password">
		<?php echo form_error('pwreset_new_password') ?>
	</div>
	
	<div class="form-group">
		<input id="pwreset-confirm-password" name="pwreset_confirm_password" type="password" class="form-control" placeholder="Confirm Password">
		<?php echo form_error('pwreset_confirm_password') ?>
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>

<?php else: ?>
<p>
	Request a password reset below. A link will be sent the e-mail address associated with your
	account. From there you will be prompted to enter a new password.
</p>

<?php if(isset($reset_error)): ?>
<p class="error"><?php echo $reset_error ?></p>
<?php endif ?>

<form id="resetForm" class="cmxform" method="POST">
	<div class="form-group">
		<label for="pwreset-username">Username:</label>
		<input id="pwreset-username" name="pwreset_username" type="text" class="form-control" placeholder="Username" value="<?php echo form_error('pwreset_email') ?>">
	</div>
	
	<p>Or</p>
	
	<div class="form-group">
		<label for="pwreset-email">E-mail:</label>
		<input id="pwreset-email" name="pwreset_email" type="email" class="form-control" placeholder="E-mail" value="<?php echo form_error('pwreset_email') ?>"> 
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>
<?php endif ?>