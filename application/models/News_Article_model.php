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
	 * @param int
	 * @param int
	 * @return array
	 */
	public function getAll($limit, $offset = 0)
	{
		$articles = TABLE_NEWS_ARTICLES;
		$associations = TABLE_NEWS_CATEGORY_ASSOC;
		$categories = TABLE_NEWS_CATEGORIES;
		$users = TABLE_USERS;
		
		$this->db->select("$articles.*, GROUP_CONCAT($associations.category_id SEPARATOR ', ') AS `category_ids`, $users.username")
				 ->from($articles)
				 ->join($users, "$articles.user_id = $users.id")
				 ->join($associations, "$articles.id = $associations.article_id", 'left')
				 ->join($categories, "$associations.category_id = $categories.id", 'left')
				 ->group_by("$articles.id")
				 ->order_by("$articles.created", 'desc')
				 ->limit($limit, $offset);
				 
		 $query = $this->db->get();
		 return $query->result();
	}
}
