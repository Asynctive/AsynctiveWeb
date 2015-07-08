<?php
/**
 * Asynctive Web User Settings Controller
 * @author Andy Deveaux
 */
class Settings extends Site_Controller
{
	public function __construct()
	{
		parent::__construct('user_settings');		
	}
	
	public function index()
	{
		$this->load->library('form_validation');
		if (!empty($_POST))
		{
			unset($_SESSION['verification_sent']);
			$email = $this->input->post('update_email');
			$new_password = $this->input->post('update_password');
			
			if ($new_password != '')
				$this->form_validation->set_rules('update_password', 'New Password', 'min_length[6]|max_length[72]');
						
			$this->form_validation->set_rules($this->USER_UPDATE_RULES);
			if ($this->form_validation->run())
			{
				$data = array();
				$data['email'] = $email;
								
				$this->db->trans_start();
				
				if ($new_password != '')
					$data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
				
				// They aren't verified anymore
				$old_user = $this->user_model->getUserById($_SESSION['user_id']);
				if ($email != $old_user->email)
				{
					$data['email_verified'] = FALSE;
					$_SESSION['email_verified'] = FALSE;
					$this->resend_verification(FALSE);
				}
				
				$this->user_model->updateUserById($data, $_SESSION['user_id']);
				
				$this->db->trans_complete();				
				if ($this->db->trans_status() !== FALSE)
				{
					$this->data['updated'] = TRUE;
				}
			}
			
			$this->data['user_email'] = $email;
		}
		
		else
		{
			$user = $this->user_model->getUserById($_SESSION['user_id']);
			$this->data['user_email'] = $user->email;
		}
		
		$this->_render('pages/user_settings.php');
	}
	
	public function resend_verification($redirect = TRUE)
	{
		$this->load->helper(array('uuid', 'random'));
		$this->load->model('pending_email_model');
		
		// Don't send one if already verified
		$user = $this->user_model->getUserById($_SESSION['user_id']);
		if (!$_SESSION['email_verified'])
		{
			$this->pending_email_model->deleteVerificationByUserId($_SESSION['user_id']);
			$this->pending_email_model->createVerification(generateUUIDv4(), $_SESSION['user_id'], generateRandomHexString(8), time());
			
			$this->session->set_flashdata('verification_sent', TRUE);
		}
		
		if ($redirect)
			redirect('/settings', 200);
	}

	public function check_email()
	{
		$email = $this->input->post('update_email');
		if ($email !== null)
		{
			$id = $this->user_model->getIdByEmail($email);
			if ($id === FALSE || $id == $_SESSION['user_id'])
				echo 'true';
			else
				echo 'false';
		}
		
		else
		{
			echo 'false';
		}
	}
	
	/**
	 * Callback function for checking if unique e-mail (unless it's the logged in user's)
	 * @param string
	 * @return bool
	 */
	public function _checkEmail($value)
	{
		$user_id = $this->user_model->getIdByEmail($value);
		if ($user_id !== FALSE && $user_id != $_SESSION['user_id'])
		{
			$this->form_validation->set_message('_checkEmail', 'This e-mail is already taken');
			return FALSE;
		}
		
		return TRUE;
	}
	
	private $USER_UPDATE_RULES = array(
		array(
			'field' => 'update_email',
			'label' => 'E-mail',
			'rules' => 'trim|required|valid_email|callback__checkEmail'
		),
		
		array(
			'field' => 'update_confirm_password',
			'label' => 'Confirm New Password',
			'rules' => 'matches[update_password]'
		)
	);
}
