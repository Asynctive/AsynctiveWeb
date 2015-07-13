<?php
/**
 * Asynctive Web Admin - News Articles Controller
 * @author Andy Deveaux
 */
class Articles extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct('admin_view_articles');
		$this->data['title'] = 'News Articles';
		$this->load->model('news_article_model');		
	}
	
	public function index()
	{
		$this->load->model('news_category_model');
		
		$articles = $this->news_article_model->getAll(10, 0);
		$category_records = $this->news_category_model->getAll();
		// Make it single dimensional
		$category_records_refined = array();
		foreach($category_records as $cat)
			$category_records_refined[$cat->id] = $cat->name;
		
		foreach($articles as &$article)
		{
			$category_ids = explode(', ', $article->category_ids);
			$article->categories = array();
			foreach($category_ids as $cat_id)
			{
				if (array_key_exists($cat_id, $category_records_refined))
					$article->categories[] = array('id' => $cat_id, 'name' => $category_records_refined[$cat_id]); 
			}
		}
		
		$this->data['articles'] = $articles;
		$this->_render('admin/view_articles.php');
	}
	
	public function create()
	{
		if (!$this->roles->hasPermission($this->userRoles, PERMISSION_CREATE_NEWS_ARTICLE))
			redirect('/admin/news/articles', 200);
			
		$this->data['page'] = 'admin_create_article';
		$this->data['title'] = 'Create News Article';
		
		$this->load->model('news_category_model');
		$this->data['categories'] = $this->news_category_model->getAll();
		
		$this->load->library('form_validation');
		
		if (!empty($_POST))
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'article_title',
					'label' => 'Title',
					'rules' => 'trim|required'
				),
				
				array(
					'field' => 'article_content',
					'label' => 'Content',
					'rules' => 'required'
				)
			));
			
			$selected_categories = $this->input->post('article_categories');
			$this->data['selected_categories'] = $selected_categories;
			
			if ($this->form_validation->run())
			{
				$data = array(
					'user_id' => $_SESSION['user_id'],
					'title' => $this->input->post('article_title'),
					'content' => $this->input->post('article_content'),
					'created' => time(),
					'updated' => 0
				);
				
				$this->db->trans_start();
				
				$article_id = $this->news_article_model->create($data);
				
				$this->load->model('news_category_assoc_model');
				$data = $this->_makeDbCategoriesArray($selected_categories, $article_id);
				if (!empty($data))
					$this->news_category_assoc_model->insertBatch($data);
				
				$this->db->trans_complete();
				if ($this->db->trans_status())
					$this->data['success_message'] = 'Article created successfully';
			}
			
			$this->data['article'] = array(
				'title' => $this->input->post('article_title'),
				'content' => $this->input->post('article_content')
			);
		}
		else
		{
			$this->data['article'] = array('title' => '', 'content' => '');
		}
	
		
		$this->_render('admin/article_form.php');
	}

	public function edit($id = null)
	{
		if ($id === null || !$this->roles->hasPermission($this->userRoles, PERMISSION_EDIT_NEWS_ARTICLE))
			redirect('/admin/news/articles', 200);
		
		$article_record = $this->news_article_model->getById($id);
		if ($article_record !== FALSE)
		{
			$this->load->library('form_validation');
			$this->load->model('news_category_assoc_model');
			$this->load->model('news_category_model');
			
			$this->data['categories'] = $this->news_category_model->getAll();
			$record_categories = $this->news_category_assoc_model->getByArticleId($id);
			// Make it single dimensional for easy searching
			$sd_record_categories = array();
			foreach($record_categories as $cat)
				$sd_record_categories[] = $cat->category_id;
			
			if (!empty($_POST))
			{
				$this->form_validation->set_rules(array(
					array(
						'field' => 'article_title',
						'label' => 'Title',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'article_content',
						'label' => 'Content',
						'rules' => 'required'
					)
				));
				
				if ($this->form_validation->run())
				{
					$this->db->trans_start();
					
					$this->news_article_model->updateById(array(
						'title' => $this->input->post('article_title'),
						'content' => $this->input->post('article_content')
					), $id);
					
					$categories = $this->_getUpdatedCategories($this->input->post('article_categories'), $sd_record_categories);
					if (!empty($categories['remove']))
						$this->news_category_assoc_model->removeByArticleAndCategoryIds($id, $categories['remove']);
					
					$data = $this->_makeDbCategoriesArray($categories['add'], $id);
					if (!empty($data))
						$this->news_category_assoc_model->insertBatch($data);
					
					$this->db->trans_complete();
					if ($this->db->trans_status())
						$this->data['update_message'] = 'Article updated successfully';
					
				}
				
				$this->data['article'] = array(
					'title' => $this->input->post('article_title'),
					'categories' => $this->input->post('article_categories'),
					'content' => $this->input->post('article_content')
				);
			}
			
			else
			{
				$this->data['article'] = array(
					'title' => $article_record->title,
					'categories' => $sd_record_categories,
					'content' => $article_record->content
				);
			}
		}
		
		else
		{
			redirect('/admin/news/articles', 200);
		}
		
		$this->_render('admin/article_form.php');
	}

	public function delete()
	{
		if (!$this->roles->hasPermission($this->userRoles, PERMISSION_DELETE_NEWS_ARTICLE))
		{
			echo '{"success": false, "message": "Access denied"}';
			exit;
		}
		
		$ids = $this->input->post('article_ids');
		if (!empty($ids))
		{		
			if ($this->news_article_model->deleteByIds($ids) > 0)
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
	 * Returns what categories were added or removed
	 * @param array
	 * @param int
	 * @param array
	 */
	private function _getUpdatedCategories($selected_categories, $record_categories)
	{
		$categories['remove'] = array();
		$categories['add'] = array();
		
		// Get what was added
		foreach($selected_categories as $cat)
		{
			if ($cat == '')
				continue;
			
			$pos = array_search($cat, $record_categories);
			if ($pos === FALSE)
				$categories['add'][] = $cat;
			
			// Non-changing
			else
				unset($record_categories[$pos]);
		}

		// What was removed
		foreach($record_categories as $cat)
			$categories['remove'][] = $cat;
		
		return $categories;
	}

	/**
	 * Makes a multi-dimensional array for inserting a batch of category associations
	 * @param array
	 * @param int
	 * @return array
	 */
	private function _makeDbCategoriesArray($selected_categories, $article_id)
	{
		$data = array();
		foreach ($selected_categories as $category_id)
		{
			if ($category_id == '')
				continue;
			
			$data[] = array(
				'article_id' => $article_id,
				'category_id' => $category_id
			);
		}
		
		return $data;
	}
}
