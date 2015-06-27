<?php
/**
 * Asynctive Web Base Page Controller
 * @author Andy Deveaux
 */
class MY_Controller extends CI_Controller
{
	protected $DATA = array();
	
	public function __construct($page)
	{
		parent::__construct();
		$this->DATA['page'] = $page;
	}

	public function render($path = '')
	{		
		$this->load->view('header.php', $this->DATA);
		$this->load->view($path, $this->DATA);
		$this->load->view('footer.php', $this->DATA);
	}
}
