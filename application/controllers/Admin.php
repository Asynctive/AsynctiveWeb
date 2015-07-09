<?php
/**
 * Asynctive Web Admin Controller
 * @author Andy Deveaux
 */
class Admin extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct('admin_panel');
		$this->data['title'] = 'Admin Control Panel';
	}
	
	public function index()
	{
		
	}
}
