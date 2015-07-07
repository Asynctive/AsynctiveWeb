<?php
/**
 * Asynctive Web User Bans Model Class
 * @author Andy Deveaux
 */
class User_Ban_model extends CI_Model
{
	/**
	 * Gets an active ban by user id
	 * @param int
	 * @return array|bool
	 */
	public function getActiveByUserId($user_id)
	{
		$this->db->select('*')
				 ->from(TABLE_USER_BANS)
				 ->where("user_id = $user_id AND (expires > " . time() . " OR expires = 0)")
				 ->limit(1);
		
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return FALSE;
		
		return $query->row();
	}
	
	/**
	 * Gets an active record ban by IP address
	 * @param string
	 * @return array|bool
	 */
	public function getActiveByIpAddress($ip_address)
	{
		$this->db->select('*')
				 ->from(TABLE_USER_BANS)
				 ->where("ip_address = '$ip_address' AND (expires > " . time() . " OR expires = 0)")
				 ->limit(1);
				 
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return FALSE;
		
		return $query->row();
	}
}
