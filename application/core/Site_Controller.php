<?php
/**
 * Asynctive Web Site Controller
 * @author Andy Deveaux
 */
class Site_Controller extends AS_Controller
{
	protected $userRoles = array();
	
	public function __construct($page)
	{
		parent::__construct();
		
		$this->_checkSiteStatus();
		
		$this->data['page'] = $page;
		$this->data['title'] = $this->_generateTitle($page);
		
		$login_user = $this->_checkForLoginAttempt();
		// Log them in
		$success = (is_array($login_user) && array_key_exists('success', $login_user) && $login_user['success']);
		if ($success)
		{
			$this->_getUserRoles($login_user['data']->id);
			$_SESSION['logged_in'] = TRUE;
			$_SESSION['user_id'] = $login_user['data']->id;
			$_SESSION['username'] = $login_user['data']->username;
			$_SESSION['email_verified'] = $login_user['data']->email_verified;
		}
		
		// null means no login attempt
		else if ($login_user !== null)
		{
			$this->data['login_failed'] = TRUE;
		}
		
		// If logged in
		if (isset($_SESSION['logged_in']))
		{
			$this->data['logged_in'] = TRUE;
			$this->data['username'] = $_SESSION['username'];
			$this->data['email_verified'] = $_SESSION['email_verified'];
			
			// Check if banned
			$ban_record = $this->user_ban_model->getActiveByUserId($_SESSION['user_id']);
			if ($ban_record !== FALSE)
			{
				$this->data['banned'] = TRUE;
				$this->data['ban'] = array(
					'title' => 'Account Frozen',
					'message' => "We're sorry but this account is banned",
					'reason' => $ban_record->reason
				);
			}
			
		}
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
		
		else if ($this->config->item('offline_mode') && !$this->roles->hasPermission($this->userRoles, PERMISSION_VIEW_OFFLINE_SITE))
			show_error('Website is offline', 200);
	}
}
