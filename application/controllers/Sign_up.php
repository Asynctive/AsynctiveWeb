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
		$this->_render('pages/sign_up.php');
	}
	
	private $SIGNUP_RULES = array(
		array(
			'field' => 'first_name',
			'label' => 'First Name',
			'rules' => 'trim|required|max_length[200]|htmlspecialchars|xss_clean'
		),
		
		array(
			'field' => 'last_name',
			'label' => 'Last Name',
			'rules' => 'trim|required|max_length[200]|htmlspecialchars|xss_clean'
		),
		
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required|min_length[4]|max_length[200]|alpha_dash|is_unique[users.username]'
		),
		
		array(
			'field' => 'email',
			'label' => 'E-mail',
			'rules' => 'trim|required|valid_email'
		),
		
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[6]|max_length[72]|callback_checkPassword'
		),
		
		array(
			'field' => 'confirm_password',
			'label' => 'Confirm Password',
			'rules' => 'required|matches[password]'
		)
	);
	
}
