<?php
/**
 * Asynctive Web Admin - News Articles Controller
 * @author Andy Deveaux
 */
class Articles extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct('admin_news_articles');
		$this->data['title'] = 'News Articles';		
	}
	
	public function index()
	{
		
	}
}
