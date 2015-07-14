<?php
/**
 * Asynctive Web News Article Model
 * @author Andy Deveaux
 */
class News_Article_model extends CI_Model
{
	/**
	 * Creates a new article
	 * @param array
	 * @return int
	 */
	public function create($data)
	{
		$this->db->insert(TABLE_NEWS_ARTICLES, $data);
		return $this->db->insert_id();
	}
	
	/**
	 * Retrieves all articles
	 * @param string
	 * @param string
	 * @param string
	 * @param int
	 * @param int
	 * @return array
	 */
	public function get($search = '', $sort_column = 'created', $order = 'desc', $creator = '', $category = '', $start_date = 0, $end_date = 0, $limit = 10, $offset = 0)
	{
		$articles = TABLE_NEWS_ARTICLES;
		$associations = TABLE_NEWS_CATEGORY_ASSOC;
		$categories = TABLE_NEWS_CATEGORIES;
		$users = TABLE_USERS;
		
		// Active Record doesn't automatically escape these in the strings I use them in
		$creator = $this->db->escape_str($creator);
		$category = $this->db->escape_str($category);
		
		$where_category = "CASE WHEN '$category' != '' THEN " . 
				  		  "EXISTS(SELECT 1 FROM $categories INNER JOIN $associations ON $associations.category_id = $categories.id WHERE $categories.name = '$category' AND ".
				  		  "$associations.article_id = a.id) ELSE TRUE END";
				  		 
		$this->db->select("a.*, GROUP_CONCAT($associations.category_id SEPARATOR ', ') AS `category_ids`, $users.username")
				 ->from($articles . ' AS a')
				 ->join($users, "a.user_id = $users.id")
				 ->join($associations, "a.id = $associations.article_id", 'left')
				 ->join($categories, "$associations.category_id = $categories.id", 'left')
				 ->like("a.title", $search)
				 ->where("CASE WHEN '$creator' != '' THEN $users.username = '$creator' ELSE TRUE END")
				 ->where($where_category, NULL, FALSE)
				 ->where("a.created >= $start_date AND a.created <= $end_date")
				 ->group_by("a.id")
				 ->order_by("a.$sort_column", $order)
				 ->limit($limit, $offset);
				 
		 $query = $this->db->get();
		 return $query->result();
	}
	
	/**
	 * Returns the total number of articles matching a search query
	 * @return int
	 */
	public function count($search = '', $creator = '', $category = '', $start_date = 0, $end_date)
	{
		$articles = TABLE_NEWS_ARTICLES;
		$associations = TABLE_NEWS_CATEGORY_ASSOC;
		$categories = TABLE_NEWS_CATEGORIES;
		$users = TABLE_USERS;
		
		// Active Record doesn't automatically escape these in the strings I use them in
		$creator = $this->db->escape_str($creator);
		$category = $this->db->escape_str($category);
		
		$where_category = "CASE WHEN '$category' != '' THEN " . 
				  		  "EXISTS(SELECT 1 FROM $categories INNER JOIN $associations ON $associations.category_id = $categories.id WHERE $categories.name = '$category' AND ".
				  		  "$associations.article_id = a.id) ELSE TRUE END";
				  		  
		$this->db->select('COUNT(DISTINCT(a.id)) AS `total`')
				 ->from($articles . ' AS a')
				 ->join($users, "a.user_id = $users.id")
				 ->join($associations, "a.id = $associations.article_id", 'left')
				 ->join($categories, "$associations.category_id = $categories.id", 'left')
				 ->like("a.title", $search)
				 ->where("CASE WHEN '$creator' != '' THEN $users.username = '$creator' ELSE TRUE END")
				 ->where($where_category, NULL, FALSE)
				 ->where("a.created >= $start_date AND a.created <= $end_date");
				 
		$query = $this->db->get();		
		if ($query->num_rows() == 0)
			return 0;
		
		$row = $query->row();
		return $row->total;
	}
	
	/**
	 * Gets an article by id
	 * @param int
	 * @return array|bool
	 */
	public function getById($id)
	{
		$query = $this->db->get_where(TABLE_NEWS_ARTICLES, array('id' => $id), 1);
		if ($query->num_rows() == 0)
			return FALSE;
		
		return $query->row();
	}
	
	/**
	 * Updates an article by id
	 * @param array
	 * @param int
	 * @return int
	 */
	public function updateById($data, $id)
	{
		$data['updated'] = time();
		$this->db->update(TABLE_NEWS_ARTICLES, $data, array('id' => $id));
		return $this->db->affected_rows();
	}
	
	/**
	 * Deletes a bunch of articles by ids
	 * @param array
	 * @return int
	 */
	public function deleteByIds($ids)
	{
		$this->db->where_in('id', $ids);
		$this->db->delete(TABLE_NEWS_ARTICLES);
		return $this->db->affected_rows();
	}
}
