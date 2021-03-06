<?php
/**
 * Asynctive Web User Role Associations Model Class
 * @author Andy Deveaux
 */
class User_Role_Assoc_model extends CI_Model
{
	/**
	 * Adds a user to a role
	 * @param int
	 * @param int
	 * @return int
	 */
	public function addUserToRole($user_id, $role_id)
	{
		$this->db->insert(TABLE_USER_ROLE_ASSOC, array('user_id' => $user_id, 'role_id' => $role_id));
		return $this->db->insert_id();
	}
	
	/**
	 * Adds a user to a bunch of roles
	 * @param int
	 * @param array
	 */
	public function addUserToRoles($user_id, $roles)
	{
		$batch = array();
		foreach($roles as $role)
			$batch[] = array('user_id' => $user_id, 'role_id' => $role);
		
		$this->db->insert_batch(TABLE_USER_ROLE_ASSOC, $batch);
	}
	
	/**
	 * Check if anybody is in a role
	 * @param int
	 */
	public function getRoleIsEmpty($role_id)
	{
		$this->db->select('id')
				 ->from(TABLE_USER_ROLE_ASSOC)
				 ->where('role_id', $role_id)
				 ->limit(1);
				 
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return TRUE;
		
		else
			return FALSE;
	}
	
	/**
	 * Removes a user from a role
	 * @param int
	 * @param int
	 */
	public function removeUserFromRole($user_id, $role_id)
	{
		$this->db->delete(TABLE_USER_ROLE_ASSOC, array('user_id' => $user_id, 'role_id' => $role_id));
	}
}
