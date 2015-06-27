<?php
/**
 * Asynctive Web Home Page Controller
 * @author Andy Deveaux
 */
class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct('home');
	}
		
	public function index()
	{
		$this->render('pages/home.php');
	}
}
