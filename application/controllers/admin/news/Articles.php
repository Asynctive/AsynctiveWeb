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
				if (!empty($data))
					$this->news_category_assoc_model->insertBatch($data);
				
				$this->db->trans_complete();
				if ($this->db->trans_status())
				{
					$this->data['success_message'] = 'Article created successfully';
				}
			}
		}
		
		$this->_render('admin/article_form.php');
	}
}
