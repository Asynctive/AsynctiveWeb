/*
 * Asynctive Web Admin Password Reset Script
 * Author: Andy Deveaux
 */
$('document').ready(function() {
	jQuery.validator.addMethod('password', checkPassword, 'Passwords require at least one uppercase letter, one lowercase letter, and one number');
	
	$('#resetForm').validate({
		onkeyup: false,
		
		rules: {
			'pwreset_new_password': {
				required: true,
				minlength: 8,
				password: true
			},
			
			'pwreset_confirm_password': {
				required: true,
				equalTo: '#pwreset-new-password'
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
