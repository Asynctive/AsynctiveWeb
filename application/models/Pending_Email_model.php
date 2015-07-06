<?php
/**
 * Asynctive Web Pending Email Model Class
 * @author Andy Deveaux
 */
class Pending_Email_model extends CI_Model
{
	/**
	 * Creates a new e-mail verification
	 * @param array
	 * @return int
	 */
	public function createVerification($id, $user_id, $code, $created)
	{
		$this->db->insert(TABLE_PENDING_EMAILS, array('id' => $id, 'user_id' => $user_id, 'code' => $code, 'created' => $created));
		return $this->db->insert_id();
	}
	
	/**
	 * Gets a verification by id and code
	 * @param string
	 * @param string
	 * @return array|bool
	 */
	public function getVerificationByIdAndCode($id, $code)
	{
		$this->db->select('*')
				 ->from(TABLE_PENDING_EMAILS)
				 ->where('id', $id)
				 ->where('code', $code)
				 ->limit(1);
				 
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return FALSE;
		
		RETURN $query->row();
	}
	
	/**
	 * Deletes an e-mail verification
	 * @param int
	 */
	public function deleteVerificationById($id)
	{
		$this->db->delete(TABLE_PENDING_EMAILS, array('id' => $id));
	}
	
	/**
	 * Deletes an e-mail verification by user id
	 * @param int
	 */
	public function deleteVerificationByUserId($user_id)
	{
		$this->db->delete(TABLE_PENDING_EMAILS, array('user_id' => $user_id));
	}
}
