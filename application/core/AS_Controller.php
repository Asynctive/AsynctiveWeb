<?php
/**
 * Asynctive Web Base Page Controller
 * @author Andy Deveaux
 */
class AS_Controller extends CI_Controller
{
	protected $data = array();
	//protected $user;			// Currently logged in user record
	protected $userRoles;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->config->load('asynctive_config.php');
		$this->load->helper('url');
		$this->load->model(array('user_model', 'user_role_assoc_model', 'user_ban_model'));
		$this->load->library(array('session', 'roles'));
		
		// If logged in
		if (array_key_exists('user_id', $_SESSION))
			$this->_getUserRoles($_SESSION['user_id']);
	}
	
	public function logout()
	{
		session_destroy();
		if (substr(uri_string(), 0, 5) == admin)
			redirect('/admin', 200);
		
		else
			redirect('/', 200);
	}
	
	/**
	 * Checks if the user is attempting to login
	 * Returns null if they aren't, or array if they are
	 * @return array|null
	 */
	protected function _checkForLoginAttempt()
	{
		$username = $this->input->post('login_username');
		$password = $this->input->post('login_password');
		if ($username !== null && $password !== null)
		{
			$user = $this->user_model->getUserByUsername($username);
			if ($user === FALSE)
			{
				return array('success' => FALSE);
			}
			else
			{
				if (password_verify($password, $user->password))
				{
					return array('success' => TRUE, 'data' => $user);
				}
				
				return array('success' => FALSE);
			}
		}

		return null;
	}
	
	/**
	 * Gets a user's roles
	 * @param int
	 * @return array
	 */
	protected function _getUserRoles($user_id)
	{
		$role_results = $this->user_model->getRolesByUserId($user_id);
		foreach($role_results as $role)
			$this->userRoles[] = $role->key_name;
	}
}
