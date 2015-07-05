/*
 * Asynctive Web Admin User Creation Script
 * Author: Andy Deveaux
 */

$('document').ready(function() {
	
	jQuery.validator.addMethod('password', checkPassword, 'Passwords require at least one uppercase letter, one lowercase letter, and one number');
	
	$('#createForm').validate({
		onkeyup: false,
		
		rules: {
			'username': {
				required: true,
				minlength: 4,
				remote: {
					url: '/setup/check_username',
					type: 'post',
					data: {
						username: function() {
							return $('#username').val();
						}
					}
				}
			},
			'email': {
				required: true,
				email: true,
				remote: {
					url: '/setup/check_email',
					type: 'post',
					data: {
						email: function() {
							return $('#email').val();
						}
					}
				}
			},
			'password': {
				required: true,
				minlength: 6,
				password: true
			},
			'confirm-password': {
				required: true,
				equalTo: '#password'
			}
		},
		
		messages: {
			username: {
				remote: 'Username is already taken'
			},
			
			email: {
				remote: 'E-mail is already in use'
			}
		}
	});
});


/**
 * Callback function that checks password
 * Rules: at least one uppercase letter
 * 		  at least one lowercase letter
 * 		  at least one numeric character 
 */
function checkPassword(value, element)
{
	if (/[A-Z]/.test(value) == false)
		return false;
		
	if (/[a-z]/.test(value) == false)
		return false;
		
	if (/[0-9]/.test(value) == false)
		return false;
		
	return true;
}
