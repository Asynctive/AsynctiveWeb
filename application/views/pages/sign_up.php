<h3>Member Sign Up</h3>

<form id="signupForm" class="cmxform" role="form" method="POST">
	<fieldset>
		<legend>* All fields required</legend>
		<div class="form-group">
			<label for="signup-first-name">First Name:</label>
			<input type="text" id="signup-first-name" name="signup_first_name" class="form-control" maxlength="200" placeholder="First Name">			
		</div>
		
		<div class="form-group" style="margin-top: 20px">
			<label for="signup-last-name">Last Name:</label>
			<input type="text" id="signup-last-name" name="signup_last_name" class="form-control" maxlength="200" placeholder="Last Name">
		</div>
		
		<div class="form-group" style="margin-top: 20px">
			<label for="signup-email">E-mail:</label>
			<input type="email" id="signup-email" name="signup_email" class="form-control" maxlength="256" placeholder="E-mail">
		</div>
		
		<div class="form-group">
			<label for="signup-username" style="margin-top: 20px">Username:</label>
			<input type="text" id="signup-username" name="signup_username" class="form-control" maxlength="200" placeholder="Username">
		</div>
		
		<div class="form-group" style="margin-top: 20px">
			<label for="signup-password">Password:</label>
			<input type="password" id="signup-password" name="signup_password" class="form-control" placeholder="Password">
		</div>
		
		<div class="form-group">
			<input type="password" id="signup-password-confirm" name="signup_password_confirm" class="form-control" placeholder="Confirm Password">
		</div>
		
		<div class="form-group" style="margin-top: 20px">
			<button class="btn btn-default" type="submit">Submit</button>
			<button type="reset" class="btn btn-default">Clear</button>
		</div>
	</fieldset>
</form>
