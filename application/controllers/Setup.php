<?php
/**
 * Asynctive Web Setup Controller
 * Sets up the admin account and populates the database with anything else necessary then deletes when finished
 * @author Andy Deveaux 
 */
class Setup extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct('create_user');
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
				
				// Create role if it doesn't exist
				$this->load->model('role_model');
				$role_id = $this->role_model->getIdByName('Super Admin');
				if ($role_id === FALSE)
					$role_id = $this->role_model->createRole('Super Admin', 'SUPER_ADMIN');
				
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
				$this->user_role_assoc_model->addUserToRole($user_id, $role_id);
				
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

	public function check_username()
	{
		if (!empty($_POST))
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

	public function check_email()
	{
		if (!empty($_POST))
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
}
