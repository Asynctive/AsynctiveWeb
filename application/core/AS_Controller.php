<?php
/**
 * Asynctive Web Base Page Controller
 * @author Andy Deveaux
 */
class AS_Controller extends CI_Controller
{
	protected $data = array();
	protected $user;			// Currently logged in user record
	protected $userRoles;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->config->load('asynctive_config.php');
		$this->load->helper('url');
		$this->load->model(array('user_model', 'user_role_assoc_model', 'user_ban_model'));
		$this->load->library(array('session', 'roles'));
		
		if (isset($_SESSION['user_id']))
		{
			$role_results = $this->user_model->getRoles($_SESSION['user_id']);
			foreach($role_results as $role)
				$this->userRoles[] = $role->key_name;
		}
	}
	
	public function logout()
	{
		session_destroy();
		redirect('/', 200);
	}
	
	/**
	 * Checks if the user is attempting to login
	 * Returns null if they aren't, or TRUE|FALSE if they are
	 * @return null|bool
	 */
	protected function _checkForLogin()
	{
		$username = $this->input->post('login_username');
		$password = $this->input->post('login_password');
		if ($username !== null && $password !== null)
		{
			$user = $this->user_model->getUserByUsername($username);
			if ($user === FALSE)
			{
				return FALSE;
			}
			else
			{
				if (password_verify($password, $user->password))
				{
					$this->user = $user;
					return TRUE;
				}
				
				return FALSE;
			}
		}
		
		return null;
	}
}
