<?php
/**
 * Asynctive Web User Model
 * @author Andy Deveaux
 */
class User_model extends CI_Model
{
	/**
	 * Creates a user
	 * @return int
	 */
	public function createUser($data)
	{		
		$this->db->insert(TABLE_USERS, $data);
		return $this->db->insert_id();
	}
	
	/**
	 * Gets a user id by name
	 * @return int|bool
	 */
	public function getIdByUsername($username)
	{
		$this->db->select('id')
				 ->from(TABLE_USERS)
				 ->where('username', $username)
				 ->limit(1);
				 
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return FALSE;
		
		$row = $query->row();
		return (int)$row->id;
	}
	
	/**
	 * Gets a user id by email
	 * @return int|bool
	 */
	public function getIdByEmail($email)
	{
		$this->db->select('id')
				 ->from(TABLE_USERS)
				 ->where('email', $email)
				 ->limit(1);
				 
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return FALSE;
		
		$row = $query->row();
		return (int)$row->id;
	}
	
	/**
	 * Gets the roles a user is in
	 * @return array
	 */
	public function getRoles($user_id)
	{
		$this->db->select('role_id, class')
				 ->from(TABLE_USERS)
				 ->join(TABLE_USER_ROLE_ASSOC, TABLE_USER_ROLE_ASSOC . '.user_id = ' . TABLE_USERS . '.id')
				 ->join(TABLE_ROLES, TABLE_ROLES . '.id = ' . TABLE_USER_ROLE_ASSOC . '.role_id')
				 ->where(TABLE_USERS . '.id = ' . $user_id);
				 
		$query = $this->db->get();
		return $query->result();
	}
}
