<?php
/**
 * Asynctive Web Sign Up Controller
 * @author Andy Deveaux
 */
class Sign_up extends Site_Controller
{
	public function __construct()
	{
		parent::__construct('sign_up');
	}
	
	public function index()
	{
		$this->load->library('form_validation');
		if (!empty($_POST))
		{
			$this->form_validation->set_rules($this->SIGN_UP_RULES);
			if ($this->form_validation->run())
			{
				$data = array(
					'first_name' => $this->input->post('signup_first_name'),
					'last_name' => $this->input->post('signup_last_name'),
					'username' => $this->input->post('signup_username'),
					'email' => $this->input->post('signup_email'),
					'password' => password_hash($this->input->post('signup_password'), PASSWORD_DEFAULT),
					'created' => time(),
					'updated' => time()
				);
				
				$this->db->trans_start();
				$user_id = $this->user_model->createUser($data);
				
				// Add to User role
				$this->load->model('role_model');
				$role = $this->role_model->getByKeyName(ROLE_USER);
				$this->user_role_assoc_model->addUserToRole($user_id, $role->id);
				
				// Pending e-mail
				$this->load->model('pending_email_model');
				$this->load->helper('uuid');
				$this->load->helper('random');
				$id = generateUUIDv4();
				$code = generateRandomHexString(8);
				$this->pending_email_model->createVerification($id, $user_id, $code, time());
				
				$this->db->trans_complete();
				if ($this->db->trans_status())
				{
					$this->data['title'] = 'Asynctive | Registration Complete';
					$this->data['registration_successful'] = TRUE;
					$this->data['email'] = $data['email'];
					
					$this->load->library('email');
					$this->email->from($this->config->item('verify_email_sender'));
					$this->email->to($data['email']);
					$this->email->subject('Verify Your Account');
					$message = '<html><body><a href="' . $this->config->item('site_address') . '/verify/' . $id . '/' . $code . 
								'">Click here</a> to verify your Asynctive account</body></html>';
					$this->email->message($message);
					$this->email->send();
				}
			}
		}
		
		$this->_render('pages/sign_up.php');
	}
	
	/**
	 * Method for remote checking of username
	 */
	public function check_username()
	{
		if (!empty($_POST) && $this->input->post('signup_username') !== FALSE)
		{
			if ($this->user_model->getIdByUsername($this->input->post('signup_username')) !== FALSE)
				echo 'false';
			else
				echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	/**
	 * Method for remote checking of e-mail
	 */
	public function check_email()
	{
		if (!empty($_POST) && $this->input->post('signup_email') !== FALSE)
		{
			if ($this->user_model->getIdByEmail($this->input->post('signup_email')) !== FALSE)
				echo 'false';
			else
				echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
	
	
	private $SIGN_UP_RULES = array(
		array(
			'field' => 'signup_first_name',
			'label' => 'First Name',
			'rules' => 'trim|required|max_length[200]|htmlspecialchars'
		),
		
		array(
			'field' => 'signup_last_name',
			'label' => 'Last Name',
			'rules' => 'trim|required|max_length[200]|htmlspecialchars'
		),
		
		array(
			'field' => 'signup_username',
			'label' => 'Username',
			'rules' => 'trim|required|min_length[4]|max_length[200]|alpha_dash|is_unique[users.username]'
		),
		
		array(
			'field' => 'signup_email',
			'label' => 'E-mail',
			'rules' => 'trim|required|valid_email|is_unique[users.email]'
		),
		
		array(
			'field' => 'signup_password',
			'label' => 'Password',
			'rules' => 'required|min_length[6]|max_length[72]'
		),
		
		array(
			'field' => 'signup_password_confirm',
			'label' => 'Confirm Password',
			'rules' => 'required|matches[signup_password]'
		)
	);
	
}
