<?php
/**
 * Asynctive Web Site Controller
 * @author Andy Deveaux
 */
class Site_Controller extends AS_Controller
{
	public function __construct($page)
	{
		parent::__construct();
						
		$this->_checkSiteStatus();
		
		$this->data['page'] = $page;
		$this->_generateTitle($page);
	}
		
	/**
	 * Renders a page
	 * @param string
	 */
	protected function _render($path)
	{
		if (!file_exists(VIEWPATH . $path))
			show_404();

		$this->load->view('header.php', $this->data);
		$this->load->view($path, $this->data);
		$this->load->view('footer.php', $this->data);
	}
	
	/**
	 * Generates a title based on page name
	 */
	private function _generateTitle($page)
	{
		$this->data['title'] = 'Asynctive';
		$separator = ' | ';
		// Remove spaces and capitalize words
		if (strpos($page, '_') !== FALSE)
		{
			$this->data['title'] .= $separator;
			
			$parsed = explode('_', $page);
			foreach($parsed as $key => &$word)
				$word = ucfirst($parsed[$key]);
			
			$this->data['title'] .= implode(' ', $parsed);
		}
		else if ($page !== 'home')
		{
			$this->data['title'] .= $separator . ucfirst($page);
		}
	}
	
	/**
	 * Redirects depending on site status, or does nothing
	 */
	private function _checkSiteStatus()
	{
		if (file_exists($this->config->item('controller_path') . 'Setup.php') && ENVIRONMENT == 'production')
			redirect('/setup', 200);
		
		else if ($this->config->item('site_offline'))
			show_error('Website is offline', 200);
	}
}
