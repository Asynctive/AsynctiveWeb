/*
 * Asynctive Member Sign Up Script
 * Author: Andy Deveaux
 */

$('document').ready(function() {
	
	jQuery.validator.addMethod('alpha_dash', isAlphaDash, 'Usernames may only contain letters, numbers, dashes and underscores');
	
	$('#signupForm').validate({
		onkeyup: false,
		
		rules: {
			'signup_first_name': 'required',
			'signup_last_name': 'required',
			'signup_email': {
				required: true,
				email: true,
				remote: {
					url: '/sign_up/check_email',
					type: 'post',
					data: {
						signup_email: function() {
							return $('#signup-email').val();
						}
					}					
				}
			},
			'signup_username': {
				required: true,
				minlength: 4,
				alpha_dash: true,
				remote: {
					url: '/sign_up/check_username',
					type: 'post',
					data: {
						signup_username: function() {
							return $('#signup-username').val();
						}
					}					
				}
			},
				
			'signup_password': {
				required: true,
				minlength: 6
			},
			'signup_password_confirm': {
				required: true,
				equalTo: '#signup-password'
			}
		},
		
		messages: {
			signup_email: {
				remote: 'Email is already in use'	
			},
			
			signup_username: {
				remote: 'Username is taken'
			}
		}
	});
});

function isAlphaDash(value, element)
{
	return /^[a-zA-Z0-9_-]+$/.test(value);
}
