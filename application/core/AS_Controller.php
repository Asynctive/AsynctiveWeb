<?php
/**
 * Asynctive Web Base Page Controller
 * @author Andy Deveaux
 */
class AS_Controller extends CI_Controller
{
	protected $data = array();
	
	public function __construct()
	{
		parent::__construct();
		
		$this->config->load('asynctive_config.php');
		$this->load->helper('url');
		$this->load->model(array('user_model', 'user_role_assoc_model'));
		$this->load->library('session');
	}
}
