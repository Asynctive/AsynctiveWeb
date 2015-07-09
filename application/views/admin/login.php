<h3>Admin Login</h3>

<?php if(isset($login_failure_message)): ?>
<p class="error"><?php echo $login_failure_message ?></p>
<?php endif ?>
<form id="loginForm" class="cmxform" method="POST">
	<div class="form-group">
		<label for="login-username">Username:</label>
		<input id="login-username" name="login_username" type="text" class="form-control" value="<?php if(isset($username)) echo $username ?>" placeholder="Username" style="width: 200px">
	</div>
	
	<div class="form-group">
		<label for="login-password">Password:</label>
		<input id="login-password" name="login_password" type="password" class="form-control" placeholder="Password" style="width: 200px">
		<a href="/admin/pwreset">Reset Password</a>
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>
