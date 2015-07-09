<?php
/**
 * Asynctive Web Admin Controller
 * @author Andy Deveaux
 */
class Admin_Controller extends AS_Controller
{
	public function __construct($page)
	{
		parent::__construct();
		
		$this->data['page'] = $page;
		
		// Check if they have access
		if (isset($_SESSION['user_id']))
		{
			if (!$this->roles->hasPermission($this->userRoles, PERMISSION_VIEW_ADMIN_PANEL))
				show_error('You do not have access to this area');
		}
		
		else if ($page != 'admin_login' && $page != 'admin_pwreset')
		{
			redirect('/admin', 200);
		}
	}
	
	/**
	 * Renders a page
	 * @param string
	 */
	public function _render($path)
	{
		if (!file_exists(VIEWPATH . $path))
			show_404();
		
		$this->load->view('admin/header.php', $this->data);
		$this->load->view($path, $this->data);
		$this->load->view('admin/footer.php', $this->data);
	}
	
	/**
	 * Callback for checking if a password contains required characters
	 * Rules: at least one uppercase character
	 * 		  at least one lowercase character
	 * 		  at least one numeric character
	 * @return bool
	 */
	public function _checkPassword($input)
	{
		if (preg_match_all("/[A-Z]/", $input) == 0)
		{
			$this->form_validation->set_message('_checkPassword', 'Must contain at least one uppercase letter');
			return FALSE;
		}
		
		else if (preg_match_all("/[a-z]/", $input) == 0)
		{
			$this->form_validation->set_message('_checkPassword', 'Must contain at least one lowercase letter');
			return FALSE;
		}
		
		else if (preg_match_all("/[0-9]/", $input) == 0)
		{
			$this->form_validation->set_message('_checkPassword', 'Must contain at least one number');
			return FALSE;
		}
		
		return TRUE;
	}
	
	/*
	 * Validation rules
	 */
	protected $CREATE_USER_RULES = array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required|min_length[4]|max_length[200]|alpha_dash|is_unique[users.username]'
		),
		
		array(
			'field' => 'email',
			'label' => 'E-mail',
			'rules' => 'trim|required|valid_email|is_unique[users.email]'
		),
		
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[6]|max_length[72]|callback__checkPassword'
		),
		
		array(
			'field' => 'confirm_password',
			'label' => 'Confirm Password',
			'rules' => 'required|matches[password]'
		)
	);
}
