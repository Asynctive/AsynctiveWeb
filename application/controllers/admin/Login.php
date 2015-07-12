<?php
/**
 * Asynctive Web Admin Login Controller
 * @author Andy Deveaux
 */
class Login extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct('admin_login');
		$this->data['title'] = 'Admin Control Panel';
	}
	
	public function index()
	{
		// If logged in, they shouldn't be accessing the login page
		if (array_key_exists('user_id', $_SESSION))
			redirect('/admin/main', 200);
		
		$login_user = $this->_checkForLoginAttempt();
		$success = (is_array($login_user) && array_key_exists('success', $login_user) && $login_user['success']);
		if ($success)
		{
			$this->_getUserRoles($login_user['data']->id);		// Get roles since the constructor didn't ($_SESSION['user_id'] wasn't set)
			
			// Check if banned
			if ($this->user_ban_model->getActiveByUserId($login_user['data']->id))
			{
				$this->data['login_failure_message'] = 'Account is banned';
			}
			
			// Has permission
			else if ($this->roles->hasPermission($this->userRoles, PERMISSION_VIEW_OFFLINE_SITE))
			{
				$_SESSION['logged_in'] = TRUE;
				$_SESSION['user_id'] = $login_user['data']->id;
				$_SESSION['username'] = $login_user['data']->username;
				$_SESSION['email_verified'] = $login_user['data']->email_verified;
				redirect('/admin/main', 200);
			}
			
			// Doesn't have permission
			else
			{
				$this->data['login_failure_message'] = 'Access denied';
			}
		}
		
		// null means no login attempt
		else if ($login_user !== null)
		{
			$this->data['login_failure_message'] = 'Username and or password did not match';
		}
		
		$this->data['username'] = $this->input->post('login_username');
		$this->_render('admin/login.php');

	}

	public function main()
	{
		$this->_render('admin/main.php');
	}
}
