<?php
/**
 * Asynctive Web Contact Page Controller
 * @author Andy Deveaux
 */
class Contact extends Site_Controller
{
	public function __construct()
	{
		parent::__construct('contact');		
	}
	
	public function index()
	{
		$this->_render('pages/contact.php');
	}
}
