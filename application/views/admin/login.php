<h3>Admin Login</h3>

<?php if(isset($login_failed)): ?>
<p class="error">Login failed</p>
<?php elseif(isset($access_denied)): ?>
<p class="error">That user does not have access to the admin panel</p>
<?php endif ?>
<form id="loginForm" class="cmxform" method="POST">
	<div class="form-group">
		<label for="username">Username:</label>
		<input id="username" name="username" type="text" class="form-control" value="<?php if(isset($username)) echo $username ?>" placeholder="Username" style="width: 200px">
	</div>
	
	<div class="form-group">
		<label for="password">Password:</label>
		<input id="password" name="password" type="password" class="form-control" placeholder="Password" style="width: 200px">
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>
