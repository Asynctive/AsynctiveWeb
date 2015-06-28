<?php
/**
 * Asynctive Web Contact Page Controller
 * @author Andy Deveaux
 */
class Contact extends MY_Controller
{
	public function __construct()
	{
		parent::__construct('contact');		
	}
	
	public function index()
	{
		$this->render('pages/contact.php');
	}
}