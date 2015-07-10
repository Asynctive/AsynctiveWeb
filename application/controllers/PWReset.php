<?php
/**
 * Asynctive Web Password Reset Controller
 * @author Andy Deveaux
 */
class PWReset extends Site_Controller
{
	public function __construct()
	{
		parent::__construct('pwreset');		
	}
	
	public function index($id = null, $code = null)
	{
		// Check if logged in
		if (isset($_SESSION['user_id']))
			redirect('/', 200);
		
		$this->load->library('form_validation');
		
		// Request form
		if ($id == null)
		{
			if (empty($_POST))
			{
				$this->_render('pages/pwreset.php');
			}
			else
			{
				$username = trim($this->input->post('pwreset_username'));
				$email = trim($this->input->post('pwreset_email'));
				$user_record = FALSE;
				if ($username !== '')
					$user_record = $this->user_model->getUserByUsername($username);
				
				else if ($email !== '')
					$user_record = $this->user_model->getUserByEmail($email);
				
				if ($user_record === FALSE)
				{
					$this->data['reset_error'] = 'Sorry but a valid user was not found';
				}
				
				// Deactivate records and create a new one
				else
				{
					$this->load->model('password_reset_model');
					$this->load->helper('random');
					$this->load->helper('uuid');
					$data = array(
						'id' => generateUUIDv4(),
						'user_id' => $user_record->id,
						'code' => generateRandomHexString(8),
						'remote_ip' => $this->input->ip_address(),
						'created' => time(),
						'expires' => time() + $this->config->item('password_reset_expire_time')
					);
					
					$this->db->trans_start();
					$this->password_reset_model->deactivateResetsByUserId($user_record->id);
					$this->password_reset_model->createReset($data);
					$this->db->trans_complete();
					
					if ($this->db->trans_status() == TRUE)
					{
						$this->_sendResetEmail($data, $user_record);
											
						$this->data['reset_sent'] = TRUE;
						$this->data['reset_email'] = $user_record->email;
					}
				}
				
			}
		}
		
		// Reset form
		else
		{
			$this->load->model('password_reset_model');
			$record = $this->password_reset_model->getActiveResetByIdAndCode($id, $code);
			if ($record === FALSE)
			{
				$this->data['reset_error'] = 'This password reset is invalid or no longer exists';
			}
			else
			{
				$this->data['resetting'] = TRUE;
						
				if (!empty($_POST))
				{
					$new_password = $this->input->post('pwreset_new_password');
					$this->form_validation->set_rules(array(
						array(
							'field' => 'pwreset_new_password',
							'label' => 'New Password',
							'rules' => 'required|min_length[6]'
						),
						
						array(
							'field' => 'pwreset_confirm_password',
							'label' => 'Confirm New Password',
							'rules' => 'required|matches[pwreset_new_password]'
						)
					));
					
					if ($this->form_validation->run())
					{
						$this->db->trans_start();
						$this->password_reset_model->deactivateResetById($id);
						$this->user_model->updateUserById(array('password' => password_hash($new_password, PASSWORD_DEFAULT)), $record->user_id);
						$this->db->trans_complete();
						
						if ($this->db->trans_status() == TRUE)
						{
							$this->_sendStatusEmail($record->email);
							$this->data['reset_complete'] = TRUE;
						}
					}
				}
			}
		}
		
		$this->_render('pages/pwreset.php');
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
