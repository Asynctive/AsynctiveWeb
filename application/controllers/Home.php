<?php
/**
 * Asynctive Web Home Page Controller
 * @author Andy Deveaux
 */
class Home extends Site_Controller
{
	public function __construct()
	{
		parent::__construct('home');
	}
		
	public function index()
	{
		$this->_render('pages/home.php');
	}
}
