<?php
/**
 * Asynctive Web User Role Associations Model Class
 * @author Andy Deveaux
 */
class User_Role_Assoc_model extends CI_Model
{
	/**
	 * Adds a user to a role
	 * @return int
	 */
	public function addUserToRole($user_id, $role_id)
	{
		$this->db->insert(TABLE_USER_ROLE_ASSOC, array('user_id' => $user_id, 'role_id' => $role_id));
		return $this->db->insert_id();
	}
	
	/**
	 * Removes a user from a role
	 */
	public function removeUserFromRole($user_id, $role_id)
	{
		$this->db->delete(TABLE_USER_ROLE_ASSOC, array('user_id' => $user_id, 'role_id' => $role_id));
	}
}
