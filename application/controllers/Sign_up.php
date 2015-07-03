<?php
/**
 * Asynctive Web Sign Up Controller
 * @author Andy Deveaux
 */
class Sign_up extends AS_Controller
{
	public function __construct()
	{
		parent::__construct('sign_up');
	}
	
	public function index()
	{
		$this->render('pages/sign_up.php');
	}
}
