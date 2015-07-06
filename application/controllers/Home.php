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
	
	public function verify($id = null, $code = null)
	{
		if ($id !== null)
		{
			$this->load->model('pending_email_model');
			$verification = $this->pending_email_model->getVerificationByIdAndCode($id, $code);
			if ($verification !== FALSE)
			{
				$this->db->trans_start();
				
				$this->pending_email_model->deleteVerificationById($id);
				
				$this->load->model('user_model');
				$this->user_model->updateUserById($verification->user_id, array('email_verified' => TRUE));
				
				$this->db->trans_complete();
				
				if ($this->db->trans_status() !== FALSE)
				{
					$this->data['verified'] = TRUE;
				}
			}
		}
		
		$this->_render('pages/verify.php');
	}
}
