<?php
/**
 * Asynctive Web News Categories Controller
 * @author Andy Deveaux
 */
class Categories extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct('admin_view_categories');
		$this->load->model('news_category_model');		
	}
	
	public function index()
	{
		$this->data['title'] = 'View Categories';
		$this->data['categories'] = $this->news_category_model->getAll();		
		$this->_render('admin/view_categories.php');
	}
	
	public function create()
	{
		if (!$this->roles->hasPermission($this->userRoles, PERMISSION_CREATE_NEWS_CATEGORY))
			show_error('Access denied', 200);
		
		$this->data['page'] = 'admin_create_categories';
		$this->data['title'] = 'Create Categories';
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules(array(
			array(
				'field' => 'category_name',
				'label' => 'Name',
				'rules' => 'trim|required|is_unique['. TABLE_NEWS_CATEGORIES . '.name]'
			),
			
			array(
				'field' => 'category_slug',
				'label' => 'Slug',
				'rules' => 'trim|required|alpha_dash|is_unique[' . TABLE_NEWS_CATEGORIES . '.slug]|strtolower'
			)
		));
		
		$this->data['category_name'] = $this->input->post('category_name');
		$this->data['category_slug'] = $this->input->post('category_slug');
			
		if ($this->form_validation->run())
		{
			$this->news_category_model->create($this->input->post('category_name'), $this->input->post('category_slug'));
			$this->data['success_message'] = 'Category created successfully';
		}
	
		$this->_render('admin/categories_form.php');
	}
	
	public function edit($id = null)
	{
		if (!$this->roles->hasPermission($this->userRoles, PERMISSION_EDIT_NEWS_CATEGORY))
			show_error('Access denied', 200);
			
		$this->load->library('form_validation');
		if ($id !== null)
		{
			
			if (empty($_POST))
			{
				$category = $this->news_category_model->getById($id);
				if ($category === FALSE)
					redirect('/admin/news/categories', 200);
				
				$this->data['category_name'] = $category->name;
				$this->data['category_slug'] = $category->slug;
			}
			else
			{
				$this->form_validation->set_rules(array(
					array(
						'field' => 'category_name',
						'label' => 'Name', 
						'rules' => 'trim|required|callback__isUniqueName'
					),
					array(
						'field' => 'category_slug',
						'label' => 'Slug',
						'rules' => 'trim|required|alpha_dash|callback__isUniqueSlug|strtolower'
					)
				));
				
				if ($this->form_validation->run())
				{
					$this->news_category_model->updateById($this->input->post('category_name'), $this->input->post('category_slug'), $id);
					$this->data['success_update_message'] = 'Record successfully updated';
				}
				
				$this->data['category_name'] = $this->input->post('category_name');
				$this->data['category_slug'] = $this->input->post('category_slug');
			}
		}
		else
		{
			redirect('/admin/news/categories', 200);
		}
		
		$this->data['page'] = 'admin_edit_category';
		$this->data['title'] = 'Edit Category';
		$this->_render('admin/categories_form.php');
	}

	/**
	 * Ajax delete function
	 */
	public function delete()
	{
		if (!$this->roles->hasPermission($this->userRoles, PERMISSION_DELETE_NEWS_CATEGORY))
		{
			echo '{"success": false, "message": "Access denied"}';
			exit;			
		}
		
		$ids = $this->input->post('category_ids');
		if (!empty($ids))
		{
		
			if ($this->news_category_model->deleteByIds($ids) > 0)
				echo '{"success": true}';
			else
				echo '{"success": false, "message": "Delete failed"}';
		}
		else
		{
			echo '{"success": false, "message": "No items selected"}'; 
		}
	
	}
	
	/**
	 * Checks for unique name excluding whatever was entered
	 * @param string
	 * @return bool
	 */
	public function _isUniqueName($input)
	{
		$this->form_validation->set_message('_isUniqueName', 'This name is already used');
		return $this->news_category_model->isUniqueNameExcludeId($input, $this->uri->segment(5));
	}
	
	/**
	 * Checks for unique slug excluding whatever was entered
	 * @param string
	 * @return bool
	 */
	public function _isUniqueSlug($input)
	{
		$this->form_validation->set_message('_isUniqueSlug', 'This slug is already used');
		return $this->news_category_model->isUniqueSlugExcludeId($input, $this->uri->segment(5));
	}
}
