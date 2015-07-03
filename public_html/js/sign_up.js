/*
 * Asynctive Member Sign Up Script
 * Author: Andy Deveaux
 */

$(document).ready(function() {
	$('#signupForm').validate({
		rules: {
			'signup_first_name': 'required',
			'signup_last_name': 'required',
			'signup_email': {
				required: true,
				email: true
			},
			'signup_username': {
				required: true,
				minlength: 4
				},
			'signup_password': {
				required: true,
				minlength: 6
			},
			'signup_password_confirm': {
				required: true,
				equalTo: '#signup-password'
			}
		}
	});
});
