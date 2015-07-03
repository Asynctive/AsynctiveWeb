<?php
/**
 * Asynctive Web Base Page Controller
 * @author Andy Deveaux
 */
class AS_Controller extends CI_Controller
{
	protected $DATA = array();
	
	public function __construct($page)
	{
		parent::__construct();
		$this->DATA['page'] = $page;
		$this->generateTitle($page);
	}

	public function render($path = '')
	{
		if (!file_exists(VIEWPATH . $path))
			show_404();
		
		$this->load->view('header.php', $this->DATA);
		$this->load->view($path, $this->DATA);
		$this->load->view('footer.php', $this->DATA);
	}
	
	private function generateTitle($page)
	{
		$this->DATA['title'] = 'Asynctive';
		$separator = ' | ';
		// Remove spaces and capitalize words
		if (strpos($page, '_') !== FALSE)
		{
			$this->DATA['title'] .= $separator;
			
			$parsed = explode('_', $page);
			foreach($parsed as $key => &$word)
				$word = ucfirst($parsed[$key]);
			
			$this->DATA['title'] .= implode(' ', $parsed);
		}
		else if ($page !== 'home')
		{
			$this->DATA['title'] .= $separator . ucfirst($page);
		}
	}
}
