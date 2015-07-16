<h3><?php echo $title ?></h3>
<?php if(isset($success_message)): ?>
<p class="success"><?php echo $success_message ?></p>
<?php else: ?>

<form class="cmxform" method="POST">
	<div class="form-group">
		<label for="user-first-name">First Name:</label>
		<input id="user-first-name" name="user_first_name" type="text" class="form-control" value="<?php echo $user['first_name'] ?>" placeholder="First Name" style="width: 250px">
		<?php echo form_error('user_first_name') ?>
	</div>
	
	<div class="form-group">
		<label for="user-last-name">Last Name:</label>
		<input id="user-last-name" name="user_last_name" type="text" class="form-control" value="<?php echo $user['last_name'] ?>" placeholder="Last Name" style="width: 250px">
		<?php echo form_error('user_last_name') ?>
	</div>
	
	<div class="form-group">
		<label for="user-username">Username:</label>
		<input id="user-username" name="user_username" type="text" class="form-control" value="<?php echo $user['username'] ?>" placeholder="Username" style="width: 250px">
		<?php echo form_error('user_username') ?>
	</div>
	
	<div class="form-group">
		<label for="user-email">E-mail:</label>
		<input id="user-email" name="user_email" type="text" class="form-control" value="<?php echo $user['email'] ?>" placeholder="E-mail" style="width: 350px">
		<?php echo form_error('user_email') ?>
	</div>
	
	<div class="form-group">
		<label for="user-password">Password:</label>
		<input id="user-password" name="user_password" type="password" class="form-control" placeholder="Password" style="width: 200px">
		<?php echo form_error('user_password') ?>
	</div>
	
	<div class="form-group">
		<label for="user-confirm-password">Confirm Password:</label>
		<input id="user-confirm-password" name="user_confirm_password" type="password" class="form-control" placeholder="Confirm Password" style="width: 200px">
		<?php echo form_error('user_confirm_password') ?> 
	</div>
	
	<?php if($can_change_roles): ?>
	<div class="form-group">
		<label for="user-roles">Roles:</label>
		<select id="user-roles" name="user_roles[]" class="form-control" multiple="multiple" style="width: 300px">
			<?php foreach($roles as $role): ?>
			<option value="<?php echo $role->id ?>" <?php if(in_array($role->id, $user['selected_roles'])) echo 'selected="selected"' ?>><?php echo $role->label ?></option>
			<?php endforeach ?>
		</select>
		<?php echo form_error('user_roles') ?>
	</div>
	<?php endif ?>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
		<button type="reset" class="btn btn-default">Clear</button>
	</div>
</form>
<?php endif ?>