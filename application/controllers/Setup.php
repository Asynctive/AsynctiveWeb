<?php
/**
 * Asynctive Web Setup Controller
 * Sets up the admin account and populates the database with anything else necessary then deletes when finished (if in Production environment)
 * @author Andy Deveaux 
 */
class Setup extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct('create_user');
		
		$this->_checkIfSetup();		// Adds some security if not in production environment
	}
	
	public function index()
	{
		$this->data['title'] = 'Create Admin';
		$this->load->library('form_validation');
		
		if (!empty($_POST))
		{
			if ($this->_validateCreateUser())
			{
				$this->db->trans_start();
				
				// Create roles if they doesn't exist
				$result = $this->_createRoles();				
				$super_admin_id = $result[ROLE_SUPER_ADMIN];
				
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
					'created' => time(),
					'updated' => time()
				);
				
				$user_id = $this->user_model->createUser($data);
				
				$this->load->model('user_role_assoc_model');
				$this->user_role_assoc_model->addUserToRole($user_id, $super_admin_id);
				
				$this->db->trans_complete();
				
				if ($this->db->trans_status() !== FALSE)
				{
					$this->data['created_success'] = TRUE;
					$this->data['title'] = 'Success';
					$this->_deleteFiles();
				}
			}
		}
		
		$this->_render('admin/create_user.php');
	}

	/**
	 * Method for remote checking of username
	 */
	public function check_username()
	{
		if (!empty($_POST) && $this->input->post('username') !== FALSE)
		{
			if ($this->user_model->getIdByUsername($this->input->post('username')) !== FALSE)
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
		if (!empty($_POST) && $this->input->post('email') !== FALSE)
		{
			if ($this->user_model->getIdByEmail($this->input->post('email')) !== FALSE)
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
	 * Deletes the setup files for production mode
	 */
	private function _deleteFiles()
	{
		if (ENVIRONMENT == 'production')
		{
			unlink($this->config->item('controller_path') . 'Setup.php');
		}
	}

	/**
	 * Validation function for creating a user
	 * @return bool
	 */
	public function _validateCreateUser()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->CREATE_USER_RULES);
		return $this->form_validation->run();
	}

	/**
	 * Creates a batch of roles if they don't exist
	 * @return array
	 */
	private function _createRoles()
	{
		$this->load->model('role_model');
		
		$roles = array(
			'Super Admin' => ROLE_SUPER_ADMIN,
			'Admin' => ROLE_ADMIN,
			'User' => ROLE_USER,
		);
		$role_values = array_values($roles);
		$role_results = $this->role_model->getByKeyNames($role_values);
		$existing_roles = array();			// Rows that already exist in the database
		foreach($role_results as $row)
			$existing_roles[$row->key_name] = $row->id;
		
		$ids = array();
		foreach($roles as $name => $key_name)
		{
			if (!array_key_exists($key_name, $existing_roles))
				$ids[$key_name] = $this->role_model->createRole($name, $key_name);	
			
			else
				$ids[$key_name] = $existing_roles[$key_name];		
		}
		
		return $ids;
	}

	/**
	 * Checks if website is already setup and redirects if it is
	 * @return BOOL
	 */
	private function _checkIfSetup()
	{
		// Check if all roles exist
		$this->load->model('role_model');
		$roles = array(
			ROLE_SUPER_ADMIN,
			ROLE_ADMIN,
			ROLE_USER,
		);
		$role_results = $this->role_model->getByKeyNames($roles);
		$existing_roles = array();
		foreach($role_results as $row)
			$existing_roles[$row->key_name] = $row->id;
		
		$existing_role_keys = array_keys($existing_roles);
		foreach($roles as $role)
		{
			if (!in_array($role, $existing_role_keys))
				return FALSE;
		}
		
		// Check user_role_associations table for a user in the super admin role
		// Don't need to check if the user exists because of foreign key constraints
		if (!$this->user_role_assoc_model->getRoleIsEmpty($existing_roles[ROLE_SUPER_ADMIN]))
			show_error('This website is already setup', 200);
	}
}
