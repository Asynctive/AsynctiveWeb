<?php
/**
 * Asynctive Web Role Model Class
 * @author Andy Deveaux
 */
class Role_model extends CI_Model
{
	/**
	 * Gets all of the user roles
	 * @return array
	 */
	public function getAll()
	{
		$query = $this->db->get(TABLE_ROLES);
		return $query->result();
	}
	
	/**
	 * Creates a new role
	 * @return int
	 */
	public function createRole($name, $class)
	{
		$this->db->insert(TABLE_ROLES, array('label' => $name, 'key_name' => $class));
		return $this->db->insert_id();
	}
	
	/**
	 * Gets role by key name
	 * @return array|bool
	 */
	public function getByKeyName($key_name)
	{
		$query = $this->db->get_where(TABLE_ROLES, array('key_name' => $key_name), 1);
		if ($query->num_rows() == 0)
			return FALSE;
		
		return $query->row();
	}
	
	/**
	 * Gets batch by key names
	 * @return array
	 */
	public function getByKeyNames($key_names)
	{
		$this->db->select('*')
				 ->from(TABLE_ROLES)
				 ->or_where_in('key_name', $key_names);
		
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 * Returns the role id by name
	 * @return int
	 */
	public function getIdByName($name)
	{
		$this->db->select('id')
	             ->from(TABLE_ROLES)
				 ->where('name', $name)
				 ->limit(1);
				 
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return FALSE;
		
		$row = $query->row();
		return (int)$row->id;
	}
}
