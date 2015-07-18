<?php
/**
 * Asynctive Web Admin Users Controller
 * @author Andy Deveaux
 */
class Users extends Admin_Controller
{
	public $ROWS_PER_PAGE = 20;
	
	public function __construct()
	{
		parent::__construct('admin_view_users');
		$this->load->model('user_model');
	}
	
	public function index($page = null)
	{
		$search = array(
			'term' => null,
			'role_id' => null,
			'start_date' => null,
			'end_date' => null
		);
		$sort = 'created';
		$order = 'desc';
		$offset = 0;
		if ($page !== null)
			$offset = $page * $this->ROWS_PER_PAGE;
		
		// Search feature
		if (count($_GET) > 0)
		{
			if (array_key_exists('search', $_GET) && $_GET['search'] != '')
				$search['term'] = trim($_GET['search']);
			
			if (array_key_exists('search_role', $_GET) && $_GET['search_role'] != '')
				$search['role_id'] = $_GET['search_role'];
			
			if (array_key_exists('search_start_date', $_GET) && $_GET['search_start_date'] != '')
				$search['start_date'] = $_GET['search_start_date'];
			
			if (array_key_exists('search_end_date', $_GET) && $_GET['search_end_date'] != '')
				$search['end_date'] = $_GET['search_end_date'];
			
			if (array_key_exists('search_sort', $_GET) && $_GET['search_sort'] != '')
			{
				// Restrict value
				$value = $_GET['search_sort'];
				if ($value == 'username' || $value == 'first_name' || $value == 'last_name' || $value == 'created' || $value == 'updated')
					$sort = $value;
			}
			
			if (array_key_exists('search_order', $_GET) && $_GET['search_order'] != '')
			{
				// Restrict value
				$value = $_GET['search_order'];
				if ($value == 'asc' || $value == 'desc')
					$order = $value;
			}
		}
		
		$this->data['title'] = 'View Users';
		$this->load->model('role_model');
		$this->data['roles'] = $this->role_model->getAll();
		$this->data['search'] = $search;
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['users'] = $this->user_model->search($search, $sort, $order, $this->ROWS_PER_PAGE, $offset);
		$this->_render('admin/view_users.php');
	}

	public function create()
	{
		$this->load->model('role_model');
		$this->load->library('form_validation');
		
		$this->data['roles'] = $this->role_model->getAll();		
		$super_admin_role_id = null;
		// Super Admin can only be set to the owner account
		foreach($this->data['roles'] as $key => $role)
		{
			if ($role->key_name == ROLE_SUPER_ADMIN)
			{
				$super_admin_role_id = $role->id;
				unset($this->data['roles'][$key]);
			}
		}

		// Get user role
		$user_role_id = null;
		foreach($this->data['roles'] as $role)
		{
			if ($role->key_name == ROLE_USER)
				$user_role_id = $role->id;
		}
		
		$user = array(
			'username' => null,
			'email' => null,
			'first_name' => null,
			'last_name' => null,
			'selected_roles' => array($user_role_id)
		);
		
		if (!empty($_POST))
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'user_username',
					'label' => 'Username',
					'rules' => 'trim|required|alpha_dash|min_length[2]|is_unique[' . TABLE_USERS . '.username]'
				),
				array(
					'field' => 'user_email',
					'label' => 'E-mail',
					'rules' => 'trim|required|valid_email|is_unique[' . TABLE_USERS . '.email]'
				),
				array(
					'field' => 'user_password',
					'label' => 'Password',
					'rules' => 'required|min_length[6]|max_length[72]|callback__checkPassword'
				),
				array(
					'field' => 'user_confirm_password',
					'label' => 'Confirm Password',
					'rules' => 'required|matches[user_password]'
				)
			));
			
			if ($this->form_validation->run())
			{
				$this->db->trans_start();
				
				$user_id = $this->user_model->createUser(array(
					'username' => $this->input->post('user_username'),
					'email' => $this->input->post('user_username'),
					'first_name' => $this->input->post('user_first_name'),
					'last_name' => $this->input->post('user_last_name'),
					'password' => password_hash($this->input->post('user_password'), PASSWORD_DEFAULT),
					'created' => time(),
					'updated' => 0
				));
				
				if ($this->roles->hasPermission($this->userRoles, PERMISSION_CHANGE_USER_ROLE))
				{
					// Further secure Super Admin status tampering by removing it from the array
					$selected_roles = $this->input->post('user_roles');
					$pos = array_search($super_admin_role_id, $selected_roles);
					if ($pos !== FALSE)
						unset($selected_roles[$pos]);
					
					$this->user_role_assoc_model->addUserToRoles($user_id, $selected_roles);
				}
				else
				{
					$this->user_role_assoc_model->addUserToRole($user_id, $user_role_id);
				}
				
				$this->db->trans_complete();
				if ($this->db->trans_status())
				{
					$this->data['success_message'] = 'User created successfully';
				}
			}
			else
			{
				$user['username'] = $this->input->post('user_username');
				$user['email'] = $this->input->post('user_email');
				$user['first_name'] = $this->input->post('user_first_name');
				$user['last_name'] = $this->input->post('user_last_name');
				$user['selected_roles'] = $this->input->post('user_roles');
			}
		}
		
		$this->data['page'] = 'admin_create_user';
		$this->data['title'] = 'Create User';
		$this->data['user'] = $user;
		$this->data['can_change_roles'] = $this->roles->hasPermission($this->userRoles, PERMISSION_CHANGE_USER_ROLE);
		$this->_render('admin/user_form.php');
	}

	public function edit($id = null)
	{
		
	}
	
	public function delete()
	{
		if (!$this->roles->hasPermission($this->userRoles, PERMISSION_DELETE_USER))
		{
			echo '{"success": false, "message": "Access denied"}';
			exit;
		}
		
		$ids = $this->input->post('user_ids');
		if (!empty($ids))
		{
			if ($this->user_model->deleteByIds($ids) > 0)
				echo '{"success": true}';
			else
				echo '{"success": false, "message": "Delete failed"}';
		}
		else
		{
			echo '{"success": false, "message": "No items selected"}';
		}
	}
}
