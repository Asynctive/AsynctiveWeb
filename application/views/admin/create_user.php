<?php if(!isset($created_success)): ?>
<h3 style="margin-top: 50px">Create Account</h3>

<div style="padding: 10px">
	<form id="createForm" method="POST">
		<div class="form-group">
			<label for="first_name">First Name (Optional):</label>
			<input id="first_name" class="form-control" name="first_name" type="text" maxlength="200" placeholder="First Name" style="width: 300px" value="<?php echo set_value('first_name')?>">
		</div>
		
		<div class="form-group">
			<label for="last_name">Last Name (Optional):</label>
			<input id="last_name" class="form-control" name="last_name" type="text" maxlength="200" placeholder="Last Name" style="width: 300px" value="<?php echo set_value('last_name') ?>">
		</div>
		
		<div class="form-group">
			<label for="username">Username:</label>
			<input id="username" class="form-control" name="username" type="text" maxlength="200" placeholder="Username" style="width: 250px" value="<?php echo set_value('username') ?>">
			<?php echo form_error('username') ?>
		</div>
		
		<div class="form-group">
			<label for="email">E-mail:</label>
			<input id="email" class="form-control" name="email" type="email" maxlength="256" placeholder="E-mail" style="width: 400px" value="<?php echo set_value('email') ?>">
			<?php echo form_error('email') ?>
		</div>
		
		<div class="form-group">
			<label for="password">Password:</label>
			<input id="password" class="form-control" name="password" type="password" maxlength="72" placeholder="Password" style="width: 250px">
			<?php echo form_error('password') ?>
		</div>
		
		<div class="form-group">
			<label for="confirm-password">Confirm Password:</label>
			<input id="confirm-password" class="form-control" name="confirm_password" type="password" maxlength="72" placeholder="Confirm Password" style="width: 250px">
			<?php echo form_error('confirm_password'); ?>
		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-default">Create</button>
			<button type="reset" class="btn btn-default">Clear</button>
		</div>
	</form>
</div>

<?php else: ?>
<h3 style="margin-top: 50px">Success</h3>

<p>
	User account created successfully.<br>
</p>
<?php endif; ?>