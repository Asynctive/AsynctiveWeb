/*
 * Asynctive Web Password Reset Script
 * Author: Andy Deveaux
 */

$('document').ready(function() {
	$('#resetForm').validate({
		onkeyup: false,
		
		rules: {
			'pwreset_new_password': {
				required: true,
				minlength: 6
			},
			
			'pwreset_confirm_password': {
				required: true,
				equalTo: '#pwreset-new-password'
			}
		}
	});
});
