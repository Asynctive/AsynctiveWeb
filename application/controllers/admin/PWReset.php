<?php
/**
 * Asynctive Web Admin Password Reset Controller
 * @author Andy Deveaux
 */
class PWReset extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct('admin_pwreset');
		$this->data['title'] = 'Password Reset';
	}
	
	public function index($id = null, $code = null)
	{
		// Don't access this page if logged in
		if (array_key_exists('user_id', $_SESSION))
			redirect('/admin/main', 200);
			
		// Request form
		if ($id === null || $code === null)
		{
			// Send request
			if (!empty($_POST))
			{
				$username = trim($this->input->post('pwreset_username'));
				$record = $this->user_model->getUserByUsername($username);
				// Record exists
				if ($record !== FALSE)
				{
					$this->_getUserRoles($record->id);
					// Has permission
					if ($this->roles->hasPermission($this->userRoles, PERMISSION_VIEW_ADMIN_PANEL))
					{
						$this->load->model('password_reset_model');
						$this->load->helper('uuid');
						$this->load->helper('random');
						$data = array(
							'id' => generateUUIDv4(),
							'user_id' => $record->id,
							'code' => generateRandomHexString(8),
							'remote_ip' => $this->input->ip_address(),
							'created' => time(),
							'expires' => time() + $this->config->item('password_reset_expire_time')
						);
						
						$this->db->trans_start();
						
						$this->password_reset_model->deactivateResetsByUserId($record->id);
						$this->password_reset_model->createReset($data);
						
						$this->db->trans_complete();
						if ($this->db->trans_status())
						{
							$this->data['reset_sent'] = TRUE;
							$this->data['reset_username'] = $username;
							$this->_sendResetEmail($data, $record);
						}
					}
					
					// Lacks permission
					else
					{
						$this->data['reset_error'] = 'That user does not have access to the admin panel';
					}					
				}
				
				else
				{
					$this->data['reset_error'] = 'Sorry but a valid user was not found';
				}
			}
		}
		
		// Reset form
		else
		{			
			$this->load->model('password_reset_model');
			$record = $this->password_reset_model->getActiveResetByIdAndCode($id, $code);
			// Reset found
			if ($record !== FALSE)
			{
				// Resetting
				$this->data['resetting'] = TRUE;
				
				$this->load->library('form_validation');
				if (!empty($_POST))
				{
					$this->form_validation->set_rules(array(
						array(
							'field' => 'pwreset_new_password',
							'label' => 'New Password',
							'rules' => 'required|min_length[8]|callback__checkPassword'
						),
						
						array(
							'field' => 'pwreset_confirm_password',
							'label' => 'Confirm New Password',
							'rules' => 'required|matches[pwreset_new_password]'
						)
					));

					if ($this->form_validation->run())
					{
						$new_password = $this->input->post('pwreset_new_password');
						
						$this->db->trans_start();
						
						$this->password_reset_model->deactivateResetsByUserId($record->user_id);
						$this->user_model->updateUserById(array('password' => password_hash($new_password, PASSWORD_DEFAULT)), $record->user_id);
						
						$this->db->trans_complete();
						if ($this->db->trans_status())
						{
							$this->_sendStatusEmail($record->email);
							$this->data['reset_complete'] = TRUE;
						}
					}
				}
			}
			
			// Not found
			else
			{
				$this->data['reset_error'] = 'This password reset is invalid or no longer exists';
			}
		}
		
		$this->_render('admin/pwreset.php');
	}

	protected function _sendResetEmail($reset, $user)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('password_reset_sender'));
		$this->email->to($user->email);
		$this->email->subject('Password Reset Request');
		$message = '<html><body><a href="' . $this->config->item('site_address') . $reset['id'] . '/' . $reset['code'] . '">Click here</a> to reset your password for' .
					" your Asynctive account '$user->username'<br><br>If you did not request this, simply ignore it." .
				   '<br>Request made from: ' . $reset['remote_ip'] .
				   '</body></html>';
		$this->email->message($message);
		$this->email->send();
	}
	
	protected function _sendStatusEmail($email)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('password_reset_sender'));
		$this->email->to($email);
		$this->email->subject('Password Has Been Reset');
		$message = '<html><body>The password to your Asynctive account has been reset</body></html>';
		$this->email->message($message);
		$this->email->send();
	}
}
