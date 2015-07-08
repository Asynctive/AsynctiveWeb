/*
 * Asynctive Web User Settings Script
 * Author: Andy Deveaux
 */

$('document').ready(function() {
	
	$('#updateForm').validate({
		onkeyup: false,
		
		rules: {
			'update_email': {
				required: true,
				email: true,
				remote: {
					url: '/settings/check_email',
					type: 'post',
					data: {
						update_email: function() {
							return $('#update-email').val();
						}
					}
				}
			},
			'update_confirm_password': {
				equalTo: '#update_password'
			}
		},
		
		messages: {
			update_email: {
				remote: 'This e-mail is taken'
			}
		}
	});
});
