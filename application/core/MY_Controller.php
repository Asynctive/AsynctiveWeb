<?php
/**
 * Asynctive Web Base Page Controller
 * @author Andy Deveaux
 */
class MY_Controller extends CI_Controller
{
	public function render($page = '', $data = array())
	{
		$this->load->view('header.php', $data);
		$this->load->view($page, $data);
		$this->load->view('footer.php', $data);
	}
}
