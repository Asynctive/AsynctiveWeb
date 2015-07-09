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
		if (!empty($_POST))
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			$record = $this->user_model->getUserByUsername($username);
			if ($record !== FALSE && password_verify($password, $record->password))
			{
				$role_results = $this->user_model->getRoles($record->id);
				foreach($role_results as $role)
					$this->userRoles[] = $role->key_name;
				
				if ($this->roles->hasPermission($this->userRoles, PERMISSION_VIEW_ADMIN_PANEL))
				{
					$_SESSION['user_id'] = $record->id;
					$_SESSION['username'] = $record->username;
					redirect('/admin/main', 200);
				}
				else
				{
					$this->data['username'] = $username; 
					$this->data['access_denied'] = TRUE;
				}
			}
			else
			{
				$this->data['username'] = $username; 
				$this->data['login_failed'] = TRUE;
			}
		}
		
		$this->_render('admin/login.php');

	}
	
	public function logout()
	{
		session_destroy();
		redirect('/admin', 200);
	}
}
