<?php
/**
 * Asynctive Web Password Reset Model
 * @author Andy Deveaux
 */
class Password_Reset_Model extends CI_Model
{
	public function createReset($data)
	{
		$this->db->insert(TABLE_PASSWORD_RESETS, $data);
	}
	
	/**
	 * Returns an active password reset by id and code
	 * @param string
	 * @param string
	 * @return array|bool
	 */
	public function getActiveResetByIdAndCode($id, $code)
	{
		$this->db->select('*')
				 ->from(TABLE_PASSWORD_RESETS)
				 ->join(TABLE_USERS, TABLE_PASSWORD_RESETS . '.user_id = ' . TABLE_USERS . '.id')
				 ->where(TABLE_PASSWORD_RESETS . '.id', $id)
				 ->where('code', $code)
				 ->where('expires >= ' . time())
				 ->limit(1);
				 
		$query = $this->db->get();
		
		if ($query->num_rows() == 0)
			return FALSE;
		
		return $query->row();
	}
	
	public function deactivateResetsByUserId($user_id)
	{
		$this->db->update(TABLE_PASSWORD_RESETS, array('expires' => 0), array('user_id' => $user_id));
	}
	
	public function deactivateResetById($id)
	{
		$this->db->update(TABLE_PASSWORD_RESETS, array('expires' => 0), array('id' => $id));
	}
}
