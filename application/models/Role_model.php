<?php
/**
 * Asynctive Web Role Model Class
 * @author Andy Deveaux
 */
class Role_model extends CI_Model
{
	/**
	 * Creates a new role
	 * @return int
	 */
	public function createRole($name, $class)
	{
		$this->db->insert(TABLE_ROLES, array('name' => $name, 'key' => $class));
		return $this->db->insert_id();
	}
	
	/**
	 * Gets role by name
	 * @return array|bool
	 */
	public function getByName($name)
	{
		$query = $this->db->get_where(TABLE_ROLES, array('name' => $name), 1);
		if ($query->num_rows == 0)
			return FALSE;
		
		return $query->row();
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
