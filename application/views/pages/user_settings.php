<h3>Account Settings</h3>
<p>This section allows you to change your user settings</p>

<?php if(isset($updated)): ?>
<p class="success">Settings updated successfully</p>
<?php 
endif; 
if($this->session->flashdata('verification_sent')): ?>
<p class="info">Verification e-mail sent</p>
<?php endif ?>

<div style="padding: 10px">
	<form id="updateForm" class="cmxform" method="POST">
		<div class="form-group">
			<label for="update-email">E-mail:</label>
			<input id="update-email" name="update_email" class="form-control" type="text" value="<?php echo $user_email ?>" placeholder="E-mail">
			<?php echo form_error('update_email') ?>
			<?php if(!$email_verified) echo '<a href="/settings/resend_verification" style="display: block">Resend Verification E-mail</a>' ?>
		</div>
		
		<div class="form-group">
			<label for="update-password">New Password:</label>
			<input id="update-password" name="update_password" type="password" class="form-control" placeholder="New Password" maxlength="72">
			<?php echo form_error('update_password') ?>
		</div>
		
		<div class="form-group">
			<input id="update-confirm-password" name="update_confirm_password" type="password" class="form-control" placeholder="Confirm New Password" maxlength="72">
			<?php echo form_error('update_confirm_password') ?>
		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-default">Update</button>
		</div>
	</form>
</div>
