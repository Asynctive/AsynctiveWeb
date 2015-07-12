<?php
/**
 * Asynctive Web News Category Model
 * @author Andy Deveaux
 */
class News_Category_model extends CI_Model
{
	/**
	 * Retrieves all of the categories
	 * @return array
	 */
	public function getAll()
	{
		$query = $this->db->get(TABLE_NEWS_CATEGORIES);
		return $query->result();
	}
	
	/**
	 * Retrieves a category by id
	 * @param int
	 * @return array|bool
	 */
	public function getById($id)
	{
		$this->db->select('*')
				 ->from(TABLE_NEWS_CATEGORIES)
				 ->where('id', $id)
				 ->limit(1);
		
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return FALSE;
		
		return $query->row();
	}
	
	/**
	 * Checks if a name is unique, excluding the id given
	 * @param string
	 * @param int
	 * @return bool
	 */
	public function isUniqueNameExcludeId($name, $id)
	{
		$this->db->select('id')
				 ->from(TABLE_NEWS_CATEGORIES)
				 ->where('name', $name)
				 ->where("id != $id")
				 ->limit(1);
				 
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return TRUE;
		
		return FALSE;
	}
	
	/**
	 * Checks if a slug is unique, excluding the id given
	 * @param string
	 * @param int
	 * @return bool
	 */
	public function isUniqueSlugExcludeId($slug, $id)
	{
		$this->db->select('id')
				 ->from(TABLE_NEWS_CATEGORIES)
				 ->where('slug', $slug)
				 ->where("id != $id")
				 ->limit(1);
				 
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			return TRUE;
		
		return FALSE;
	}
	
	/**
	 * Creates a new category
	 * @param string
	 * @param string
	 * @return int
	 */
	public function create($name, $slug)
	{
		$this->db->insert(TABLE_NEWS_CATEGORIES, array('name' => $name, 'slug' => $slug));
		return $this->db->insert_id();
	}
	
	/**
	 * Updates a category
	 * @param string
	 * @param string
	 * @param id
	 * @return int
	 */
	public function updateById($name, $slug, $id)
	{
		$this->db->update(TABLE_NEWS_CATEGORIES, array('name' => $name, 'slug' => $slug), array('id' => $id));
		return $this->db->affected_rows();
	}
	
	/**
	 * Deletes categories by id
	 * @param array
	 * @return int
	 */
	public function deleteByIds($ids)
	{
		$this->db->where_in('id', $ids);
		$this->db->delete(TABLE_NEWS_CATEGORIES);
		
		return $this->db->affected_rows();
	}
}
