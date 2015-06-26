<?php
/**
 * Asynctive Web Home Page Controller
 * @author Andy Deveaux
 */
class Home extends MY_Controller
{
	public function index()
	{
		$data['page'] = 'home';
		$this->render('pages/home.php', $data);
	}
}
